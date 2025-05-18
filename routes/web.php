<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\RabController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\DaftarKegiatanController;


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

    Route::get('/', [AuthController::class, 'index'])->name('welcome');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Tampilkan form registrasi
    Route::get('/register', [UserController::class, 'create'])->name('register');

    // Proses registrasi
    Route::post('/register', [UserController::class, 'store'])->name('registerSubmit');

    Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });


    Route::resource('users', UserController::class);
    Route::resource('organisasi', OrganisasiController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('pengajuan', PengajuanController::class);
    Route::resource('rab', RabController::class);
    Route::resource('daftar-kegiatan', DaftarKegiatanController::class);

    Route::post('/rab/import', [RabController::class, 'import'])->name('rab.import');

    Route::get('/daftar-kegiatan/{kegiatan}', [DaftarKegiatanController::class, 'index'])->name('daftar-kegiatan.index');
    Route::get('/organisasi/{id}', [OrganisasiController::class, 'profile'])->name('organisasi.profile');
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'profile'])->name('mahasiswa.profile');
    Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');

    Route::put('/pengajuan/{pengajuan}', [PengajuanController::class, 'update'])->name('pengajuan.update');Route::get('/pengajuan/{id}/edit', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
    // Route untuk menampilkan halaman update status pengajuan
    Route::get('/pengajuan/status', [PengajuanController::class, 'statusManagement'])->name('pengajuan.status');

    Route::get('/dokumen/proposal/{id}', [PengajuanController::class, 'showProposal'])->name('pengajuan.show.proposal');
    Route::get('/dokumen/lpj/{id}', [PengajuanController::class, 'showLpj'])->name('pengajuan.show.lpj');

    Route::get('/get-latest-kegiatan', [KegiatanController::class, 'getLatest'])->name('kegiatan.latest');

    Route::resource('pengajuan', PengajuanController::class, ['except' => ['show']]);

    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    

    require __DIR__.'/auth.php';


