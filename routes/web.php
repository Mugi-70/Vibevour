<?php

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
    return view('sidebar');
});

Route::get('/grup', function () {
    return view('grup');
});

Route::get('/ready_grup', function () {
    return view('ready_grup');
});

Route::get('/pembuatan_grup', function () {
    return view('pembuatan_grup');
});

Route::get('/pertemuan', function () {
    return view('pertemuan');
});

Route::get('/grup_UI', function () {
    return view('grup_UI');
});
