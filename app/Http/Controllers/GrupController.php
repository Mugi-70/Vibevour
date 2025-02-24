<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Grup;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class GrupController extends Controller
{
    //
    public function index()
    {

        //? cari period dari rentang tanggal
        //? cari period dari jam (sesuai dengan durasi)

        $grup = Grup::all();
        return view('Jadwal.grup', compact('grup'));

        // $nama_grup = "Jual-Beli";
        // $durasi = "30 menit";
        // $wtku_mulai = "07:00";
        // $wtku_selesai = "09:00";
        // $tnggl_mulai = "01 Januari 2025";
        // $tnggl_selesai = "03 Januari 2025";
        // $desk = "Lorem ipsum dolor sit amet, consectetur adipiscing elit,
        //         sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ";

        // $tgl = ["1 Januari 2025", "2 Januari 2025", "3 Januari 2025"];
        // $times = ["07:00 - 07:30", "07:30 - 08:00", "08:00 - 08:30", "08:30 - 09:00"];

        // $hadir = ["Penjual", "Notaris"];

        // return view('Jadwal.grup_UI', compact('hadir', 'nama_grup', 'durasi', 'wtku_mulai', 'wtku_selesai', 'tnggl_mulai', 'tnggl_selesai', 'desk', 'tgl', 'times'));
    }

    public function anggota()
    {
        $nama_grup = "Jual-Beli";
        $durasi = "30 menit";
        $wtku_mulai = "07:00";
        $wtku_selesai = "09:00";
        $tnggl_mulai = "01 Januari 2025";
        $tnggl_selesai = "03 Januari 2025";
        $desk = "Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ";

        $tgl = ["1 Januari 2025", "2 Januari 2025", "3 Januari 2025"];
        $times = ["07:00 - 07:30", "07:30 - 08:00", "08:00 - 08:30", "08:30 - 09:00"];

        $hadir = ["Penjual", "Notaris"];

        return view('Jadwal.grup_UI_anggota', compact('hadir', 'nama_grup', 'durasi', 'wtku_mulai', 'wtku_selesai', 'tnggl_mulai', 'tnggl_selesai', 'desk', 'tgl', 'times'));
    }

    public function pertemuan()
    {
        $anggota = ["Penjual", "Notaris", "Pembeli"];
        return view("Jadwal.pertemuan", compact('anggota'));
    }

    public function showGroup(string $id)
    {
        $grup = Grup::findOrFail($id);
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
            $tanggal_list[] = $tanggal->format('d-m-Y');
        }

        // *2. Buat daftar waktu*
        $waktu_mulai = Carbon::parse($input_waktu_mulai);
        $waktu_selesai = Carbon::parse($input_waktu_selesai);
        $periode_waktu = new CarbonPeriod($waktu_mulai, $input_durasi, $waktu_selesai);
        $waktu_list = [];
        foreach ($periode_waktu as $waktu) {
            $waktu_list[] = $waktu->format('H:i');
        }

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
        ]);
    }

    //todo Membuat Grup baru
    public function store(Request $request)
    {

        $grup = new Grup;
        $grup->nama_grup = $request->nama_grup;
        $grup->deskripsi = $request->deskripsi;
        $grup->tanggal_mulai = $request->tanggal_mulai;
        $grup->tanggal_selesai = $request->tanggal_selesai;
        $grup->waktu_mulai = $request->waktu_mulai;
        $grup->waktu_selesai = $request->waktu_selesai;
        $grup->durasi = $request->durasi;
        $grup->save();

        return redirect('/grup')->with('success', 'Grup berhasil dibuat!');
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
        $grup->save();

        return redirect('/grup_UI')->with('success', 'Grup berhasil dibuat!');
    }
}
