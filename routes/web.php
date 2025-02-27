<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoteController;
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

// Route::get('/vote', function () {
//     return view('voting.vote');
// });

Route::get('/tambahvote', function () {
    return view('voting.tambahvote');
});

Route::get('/tampilanvote', function () {
    return view('voting.tampilanvote');
});

Route::get('/hasilvote', function () {
    return view('voting.hasilvote');
});

Route::get('/vote_saya', [VoteController::class, 'index'])->name('vote.index');
Route::get('/hapus_vote', [VoteController::class, 'destroy'])->name('vote.destroy');
Route::get('/detail_vote_{slug}', [VoteController::class, 'show'])->name('vote.show');
Route::get('/detail_vote_{slug}/chart-data', [VoteController::class, 'getChartData']);

Route::get('/vote_{slug}_data', [VoteController::class, 'getVoteData']);
Route::post('/vote_{slug}_submit', [VoteController::class, 'submitVote'])->name('vote.submit');


Route::post('/simpanvote', [VoteController::class, 'store'])->name('vote.store');
