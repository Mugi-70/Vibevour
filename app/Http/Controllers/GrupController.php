<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Grup;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\AnggotaGrup;
use App\Models\Ketersediaan;
use Illuminate\Http\Request;
use App\Mail\InviteMemberMail;
use App\Models\JadwalPertemuan;
use App\Models\AnggotaGrupPending;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\JadwalPertemuanAnggota;
use App\Models\JadwalPertemuan_Anggota;

class GrupController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Grup::query();
        $today = Carbon::now();

        if ($request->has('filter')) {
            if ($request->filter == 'bulan_ini') {
                $startOfMonth = $today->copy()->startOfMonth()->format('Y-m-d');
                $endOfMonth = $today->copy()->endOfMonth()->format('Y-m-d');

                // Konversi ke y-m-d
                $query->whereBetween(
                    DB::raw("STR_TO_DATE(tanggal_mulai, '%d-%m-%Y')"),
                    [$startOfMonth, $endOfMonth]
                );
            } elseif ($request->filter == 'bulan_lalu') {
                $lastMonth = $today->copy()->subMonth();
                $startOfLastMonth = $lastMonth->startOfMonth()->format('Y-m-d');
                $endOfLastMonth = $lastMonth->endOfMonth()->format('Y-m-d');

                $query->whereBetween(
                    DB::raw("STR_TO_DATE(tanggal_mulai, '%d-%m-%Y')"),
                    [$startOfLastMonth, $endOfLastMonth]
                );
            }
        }
        $userId = 3; // sementara

        $filteredGrupIds = $query->pluck('id_grup');
        // dd($filteredGrupIds);

        // Ambil grup berdasarkan user_id di tabel AnggotaGrup
        $grup2 = AnggotaGrup::where('user_id', $userId)
            ->whereIn('grup_id', $filteredGrupIds) // Pastikan grup ada di hasil filter
            ->with('grup')
            ->get();

        return view('Jadwal.grup', compact('grup2'));
    }


    public function pertemuan()
    {
        $userId = 1;
        $jadwals = JadwalPertemuan::whereHas('peserta', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with('peserta') // memastikan daftar anggota ikut dimuat  
            ->get();
        return view("Jadwal.pertemuan", compact('jadwals'));
    }

    public function showGroup(string $id)
    {
        $grup = Grup::with('anggota.user')->findOrFail($id);

        $role = 'admin';
        // $role = 'anggota';

        //? Data dari database
        $input_tanggal_mulai = $grup->tanggal_mulai;
        $input_tanggal_selesai = $grup->tanggal_selesai;
        $input_waktu_mulai = $grup->waktu_mulai;
        $input_waktu_selesai = $grup->waktu_selesai;
        $input_durasi = $grup->durasi; //! Bisa 'minutes', 'hour', dst.

        // *1. Buat daftar tanggal*
        $tanggal_mulai = Carbon::parse($input_tanggal_mulai);
        $tanggal_selesai = Carbon::parse($input_tanggal_selesai);
        $periode_tanggal = CarbonPeriod::create($tanggal_mulai, $tanggal_selesai);
        $tanggal_list = [];
        foreach ($periode_tanggal as $tanggal) {
            $tanggal_list[] = $tanggal->format('Y-m-d');
        }

        // *2. Buat daftar waktu*
        $waktu_mulai = Carbon::parse($input_waktu_mulai);
        $waktu_selesai = Carbon::parse($input_waktu_selesai);
        $periode_waktu = new CarbonPeriod($waktu_mulai, $input_durasi, $waktu_selesai);
        $waktu_list = [];
        foreach ($periode_waktu as $waktu) {
            $waktu_list[] = $waktu->format('H:i');
        }
        $jadwalAda = JadwalPertemuan::whereIn('tanggal', $tanggal_list)
            ->whereIn('waktu_mulai', $waktu_list)
            ->where('grup_id', $grup->id_grup)
            ->exists();

        $totalAnggota = AnggotaGrup::where('grup_id', $id)->count();
        // dd($totalAnggota);

        return view('jadwal.grup_UI', [
            'nama_grup' => $grup->nama_grup,
            'tnggl_mulai' => $grup->tanggal_mulai,
            'tnggl_selesai' => $grup->tanggal_selesai,
            'wtku_mulai' => $grup->waktu_mulai,
            'wtku_selesai' => $grup->waktu_selesai,
            'durasi' => $grup->durasi,
            'desk' => $grup->deskripsi,
            'waktu_list' => $waktu_list,
            'tanggal_list' => $tanggal_list,
            'grup' => $grup,
            'role' => $role,
            'jadwalAda' => $jadwalAda,
            'totalAnggota' => $totalAnggota,
        ]);
    }

    //todo Membuat Grup baru
    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); // transaksi database

            // Buat grup baru
            $grup = new Grup();
            $grup->nama_grup = $request->nama_grup;
            $grup->deskripsi = $request->deskripsi;
            $grup->tanggal_mulai = $request->tanggal_mulai;
            $grup->tanggal_selesai = $request->tanggal_selesai;
            $grup->waktu_mulai = $request->waktu_mulai;
            $grup->waktu_selesai = $request->waktu_selesai;
            $grup->durasi = $request->durasi;
            $grup->save();

            AnggotaGrup::create([
                'grup_id' => $grup->id_grup,
                'user_id' => 3,
                'role' => 'admin'
            ]);

            // Ambil daftar anggota, jika tidak ada, buat array kosong
            $anggotaList = $request->input('anggota', []);

            if (empty($anggotaList)) {
                return response()->json(['error' => 'Tidak ada anggota yang ditambahkan!'], 400);
            }

            // Loop untuk setiap anggota
            foreach ($anggotaList as $anggota) {
                if ($anggota === 'invite') {

                    // Pastikan email dikirim dari frontend
                    $email = $request->input('email', null);
                    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return response()->json(['error' => 'Email tidak valid!'], 400);
                    }

                    // Masukkan ke tabel pending
                    AnggotaGrupPending::create([
                        'grup_id' => $grup->id_grup, // Perbaikan penggunaan id
                        'email' => $email,
                        'status' => 'Pending'
                    ]);

                    // Kirim email undangan
                    $inviteLink = url("/register?email=" . urlencode($email)); // Bisa diubah sesuai kebutuhan
                    Mail::to($email)->send(new InviteMemberMail($email, $grup->nama_grup, $inviteLink));
                } else {
                    // Masukkan ke tabel anggota grup dengan user_id yang valid
                    AnggotaGrup::create([
                        'grup_id' => $grup->id_grup,
                        'user_id' => (int) $anggota,
                        'role' => 'member'
                    ]);
                }
            }

            DB::commit(); // Simpan transaksi jika semua berhasil
            return redirect()->route('coba');
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan perubahan jika ada error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //! membuat jadwal
    public function saveSchedules(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        // Simpan jadwal
        $jadwal = JadwalPertemuan::create([
            'grup_id' => $request->grup_id,
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu,
            'durasi' => $request->durasi,
        ]);

        //tanggal, waktu, user_id create ke tabel jadwal_pertemuan_anggota
        $anggotaYangTersedia = Ketersediaan::where('tanggal', $request->tanggal)
            ->whereTime('waktu', '>=', str_pad($request->waktu, 2, '0', STR_PAD_LEFT) . ':00:00')
            ->pluck('user_id');

        // dd($anggotaYangTersedia);

        // anggota yang hadir 
        foreach ($anggotaYangTersedia as $userId) {
            // dd($userId);
            JadwalPertemuanAnggota::create([
                'jadwal_id' => $jadwal->id,
                'grup_id' => $jadwal->grup_id,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Jadwal dan anggota berhasil disimpan',
            'anggota' => $anggotaYangTersedia,
        ]);
    }

    //todo Mengedit grup
    public function update(string $id, Request $request)
    {
        $grup = Grup::findOrFail($id);
        $grup->nama_grup = $request->nama_grup;
        $grup->deskripsi = $request->deskripsi;
        $grup->tanggal_mulai = $request->tanggal_mulai;
        $grup->tanggal_selesai = $request->tanggal_selesai;
        $grup->waktu_mulai = $request->waktu_mulai;
        $grup->waktu_selesai = $request->waktu_selesai;
        $grup->durasi = $request->durasi;
        $grup->deskripsi = $request->desk;
        $grup->save();

        $anggotaList = $request->input('anggota', []);

        // Loop untuk setiap anggota
        foreach ($anggotaList as $anggota) {
            if ($anggota === 'invite') {
                // Pastikan email dikirim dari frontend

                $email = $request->input('email', null);
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return response()->json(['error' => 'Email tidak valid!'], 400);
                }

                // Masukkan ke tabel pending
                AnggotaGrupPending::create([
                    'grup_id' => $grup->id_grup,
                    'email' => $email,
                    'status' => 'Pending'
                ]);

                $inviteLink = url("/register?email=" . urlencode($email)); // Bisa diubah sesuai kebutuhan
                Mail::to($email)->send(new InviteMemberMail($email, $grup->nama_grup, $inviteLink));
            } else {
                //  Cek apakah user sudah tergabung
                $alreadyExists = AnggotaGrup::where('grup_id', $grup->id_grup)
                    ->where('user_id', $anggota)
                    ->exists();

                if ($alreadyExists) {
                    return redirect()->back()->with('toast_warning', 'anggota sudah ada di grup');
                }

                // Kalau belum tergabung, simpan ke DB
                AnggotaGrup::create([
                    'grup_id' => $grup->id_grup,
                    'user_id' => $anggota,
                    'role' => 'member'
                ]);
            }
        }

        return redirect()->back();
    }

    //todo  menghapus grup
    public function delete(string $id)
    {
        $grup = Grup::find($id);
        // if (!$grup) {
        //     return redirect()->route('coba')->with('error', 'Grup tidak ditemukan');
        // }

        $grup->delete();
        return redirect()->route('coba');
    }

    // mengeluarkan anggota dari grup
    public function delete_member(string $id)
    {
        $user = AnggotaGrup::find($id);
        $user->delete();
        return response()->json(['message' => 'berhasil']);
    }

    // anggota keluar
    public function leaveGroup($group_id)
    {
        // $user = Auth::user();
        $user_id = 1;
        $deleted = AnggotaGrup::where('grup_id', $group_id)
            ->where('user_id', $user_id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Berhasil keluar dari grup.']);
        } else {
            return response()->json(['message' => 'Gagal keluar dari grup.'], 400);
        }
    }

    //cari anggota
    public function cari_anggota(Request $request)
    {
        $search = $request->input('search', ''); // Pastikan tetap ada default string kosong

        // Ambil produk jika ada pencarian, jika tidak, tampilkan semua
        $products = User::where('name', 'LIKE', "%$search%")
            ->orWhere('email', 'LIKE', "%$search%")
            ->limit(10)
            ->get();

        return response()->json([
            'items' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'text' => $product->name,
                    'email' => $product->email
                ];
            })
        ]);
    }

    //! anggota availability
    public function simpanAvai(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'tanggal' => 'required',
            'waktu' => 'required',
        ]);

        $jadwal = Ketersediaan::create([
            'tanggal' => $request->tanggal,
            'waktu'   => $request->waktu,
            'grup_id' => $request->grup_id,
            'user_id' => $request->user_id,
        ]);

        $jadwals = Ketersediaan::where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->with('user')
            ->get();

        return response()->json([
            'message' => 'Jadwal berhasil disimpan',
            'users' => $jadwals->map(fn ($jadwal) => $jadwal->user->name)
        ], 200);
    }

    //! detail jadwal
    public function detailJadwal(string $jadwalId)
    {
        $userId = 1; // Ambil ID user yang sedang login
        // $userId = auth()->id(); // Ambil ID user yang sedang login
        $jadwal = JadwalPertemuan::with('peserta.user')->find($jadwalId);
        $grup = Grup::where('id_grup', $jadwal->grup_id)->first();

        if (!$jadwal) {
            return response()->json([], 404);
        }

        // Ambil daftar peserta yang sudah menghadiri
        $anggota = $jadwal->peserta->map(function ($peserta) {
            return [
                'name' => $peserta->user->name,
                'email' => $peserta->user->email,
            ];
        });

        // Cek apakah user yang sedang login sudah ada di peserta
        $sudahHadir = $jadwal->peserta->where('user_id', $userId)->isNotEmpty();

        return response()->json([
            'anggota' => $anggota,
            'sudahHadir' => $sudahHadir
        ]);
    }

    //! anggota menghadiri jadwal
    public function hadiriJadwal(Request $request)
    {
        // Validasi input
        $request->validate([
            'jadwal_id' => 'required|integer|exists:jadwal_pertemuan,id'
        ]);

        $userId = 1; // Ambil ID user yang sedang login

        // Cek apakah user sudah hadir
        $sudahHadir = JadwalPertemuanAnggota::where([
            'user_id' => $userId,
            'jadwal_id' => $request->jadwal_id,
            'grup_id' => $request->grup_id
        ])->exists();

        if ($sudahHadir) {
            return response()->json(['message' => 'Anda sudah menghadiri jadwal ini'], 400);
        }

        // Simpan data ke database
        JadwalPertemuanAnggota::create([
            'user_id' => $userId,
            'jadwal_id' => $request->jadwal_id,
            'grup_id' => $request->grup_id,
        ]);

        Ketersediaan::create([
            'user_id' => $userId,
            'grup_id' => $request->grup_id,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu_mulai,
        ]);

        return response()->json(['message' => 'Berhasil menghadiri jadwal']);
    }

    //!menghapus jadwal
    public function deleteJadwal(string $id)
    {
        $jadwal = JadwalPertemuan::find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan.'
            ]);
        }

        // Hapus semua peserta terkait
        $jadwal->peserta()->delete();

        // Hapus jadwal utama
        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus.'
        ]);
    }


    public function batalKehadiran(Request $request)
    {
        // Validasi request
        // $request->validate([
        //     'tanggal' => 'required|date',
        //     'waktu' => 'required|string'
        // ]);

        // Hapus data kehadiran berdasarkan tanggal dan waktu
        $kehadiran = Ketersediaan::where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->first();

        $kehadiran = Ketersediaan::where('user_id', $request->user_id)
            ->where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->first();

        if ($kehadiran) {
            $kehadiran->delete();
            return redirect()->back()->with('success', 'Kehadiran berhasil dibatalkan.');
        } else {
            return redirect()->back()->with('error', 'Kehadiran tidak ditemukan.');
        }
    }
}
