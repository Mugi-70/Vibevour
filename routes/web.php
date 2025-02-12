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

Route::get('/ready_grup', function () {
    return view('Jadwal.ready_grup');
});

Route::get('/pembuatan_grup', function () {
    return view('Jadwal.pembuatan_grup');
});

Route::get('/pertemuan', function () {
    return view('Jadwal.pertemuan');
});

Route::get('/grup_UI', [GrupController::class, 'index']);


// cari period dari rentang tanggal
// cari period dari jam (sesuai dengan durasi)

// $nama_grup = "Jual-";
// $durasi = "30 menit";
// $wtku = "07:00 s.d. 09:00";
// $tnggl = "01 Januari 2025 s.d. 03 Januari 2025";
// $desk = "coba";

// $tgl = ["01-01-2025", "02-01-2025", "03-01-2025"];
// $times = ["08:00", "08:30", "09:00", "09:30", "10:00", "10:30"];
