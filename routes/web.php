<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProposalController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'role:bpm']], function () {
    Route::get('/bpm', [HomeController::class, 'bpmDashboard'])->name('bpm.dashboard');
});

Route::group(['middleware' => ['auth', 'role:bem']], function () {
    Route::get('/bem', [HomeController::class, 'bemDashboard'])->name('bem.dashboard');
});

Route::group(['middleware' => ['auth', 'role:organisasi']], function () {
    Route::get('/organisasi', [HomeController::class, 'organisasiDashboard'])->name('organisasi.dashboard');
});

Route::group(['middleware' => ['auth', 'role:mahasiswa']], function () {
    Route::get('/mahasiswa', [HomeController::class, 'mahasiswaDashboard'])->name('mahasiswa.dashboard');
});

Route::resource('users', UserController::class);
Route::resource('organisasi', OrganisasiController::class);
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('kegiatan', KegiatanController::class);
Route::resource('proposal', ProposalController::class);
Route::post('proposal/{proposal}/status', [ProposalController::class, 'updateStatus'])->name('proposal.updateStatus');

require __DIR__.'/auth.php';
