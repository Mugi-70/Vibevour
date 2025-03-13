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


// Route::get('/tampilanvote', function () {
//     return view('voting.tampilanvote');
// });

Route::get('/hasilvote', function () {
    return view('voting.hasilvote');
});

Route::get('/tambahvote', function () {
    return view('voting.tambahvote');
});

Route::get('/vote_saya', [VoteController::class, 'index'])->name('vote.index');
Route::get('/detail_vote_{slug}', [VoteController::class, 'show'])->name('vote.show');
Route::get('/detail_vote_{slug}/data', [VoteController::class, 'getVoteDetail']);
Route::get('/detail_vote_{slug}/vote-summary', [VoteController::class, 'getVoteSummary']);
Route::get('/detail_vote_{slug}/chart-data', [VoteController::class, 'getChartData']);

Route::post('/simpan_vote', [VoteController::class, 'store'])->name('vote.store');
Route::get('/edit_vote_{slug}', [VoteController::class, 'edit'])->name('vote.edit');
Route::put('/update_vote_{slug}', [VoteController::class, 'update'])->name('vote.update');
Route::delete('/hapus_vote_{slug}', [VoteController::class, 'destroy'])->name('vote.destroy');


Route::get('/vote_{slug}', [VoteController::class, 'vote'])->name('vote.vote');
Route::get('/vote_{slug}/data', [VoteController::class, 'getVoteData']);
Route::get('/vote_{slug}/check-protection', [VoteController::class, 'checkProtection']);
Route::post('/vote_{slug}/verify-access', [VoteController::class, 'verifyAccess']);
Route::post('/vote_{slug}/submit', [VoteController::class, 'storeVoteData'])->name('vote.storeVote');
