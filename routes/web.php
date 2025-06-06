<?php

use App\Http\Controllers\GrupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Jadwal.sidebar');
});

Route::get('/grup', function () {
    return view('Jadwal.grup');
});

Route::get('/pembuatan_grup', function () {
    return view('Jadwal.pembuatan_grup');
});

Route::get('/grup', [GrupController::class, 'index'])->name('coba');

//membuat grup
Route::post('/create/grup', [GrupController::class, 'store'])->name('coba_bikin');
//edit grup
Route::put('/edit/grup/{id}', [GrupController::class, 'update'])->name('coba_edit');
//hapus grup
Route::post('/hapus_grup/{id}', [GrupController::class, 'delete'])->name('coba_hapus');

//menampilkan grup sesuai yang dipilih
Route::get('/grup_UI/{id}', [GrupController::class, 'showGroup'])->name('grup.detail');

Route::post('/schedules', [GrupController::class, 'simpanAvai']);
Route::post('/saveSchedules', [GrupController::class, 'saveSchedules']);

Route::post('/undang', [GrupController::class, 'undang']);

Route::get('/grup_UI_anggota', [GrupController::class, 'anggota']);
Route::get('/pertemuan', [GrupController::class, 'pertemuan'])->name('pertemuan');
Route::get('/jadwal/detail/{id}', [GrupController::class, 'getDetailJadwal']);


//coba cari 
Route::get('/cari', [GrupController::class, 'cari_anggota']);

Route::post('/hapus_member/{id}', [GrupController::class, 'delete_member'])->name('hapus_member');

Route::get('/jadwal/{jadwalId}/anggota', [GrupController::class, 'detailJadwal']);
Route::delete('/jadwal/{id}', [GrupController::class, 'deleteJadwal']);

Route::delete('/grup/{grup_id}/keluar', [GrupController::class, 'leaveGroup']);

Route::post('/batalAvai', [GrupController::class, 'batalKehadiran'])->name('batal.kehadiran');
Route::post('/hadiri-jadwal', [GrupController::class, 'hadiriJadwal']);



// cari period dari rentang tanggal
// cari period dari jam (sesuai dengan durasi)

// $nama_grup = "Jual-";
// $durasi = "30 menit";
// $wtku = "07:00 s.d. 09:00";
// $tnggl = "01 Januari 2025 s.d. 03 Januari 2025";
// $desk = "coba";

// $tgl = ["01-01-2025", "02-01-2025", "03-01-2025"];
// $times = ["08:00", "08:30", "09:00", "09:30", "10:00", "10:30"];
