<?php

use App\Http\Controllers\admin\AddDokterController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DokterController;
use App\Http\Controllers\admin\PasienController;
use App\Http\Controllers\admin\PoliklinikController;
use App\Http\Controllers\admin\RekamMedisController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\user\CronJobController;
use App\Http\Controllers\user\RekamMedisUserController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role->name === 'dokter') {
            return redirect()->route('dokter.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    return redirect()->route('login');
})->name('home');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('poliklinik', PoliklinikController::class);
    Route::resource('add-dokter', AddDokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::get('/pasien/{user}/rekam-medis', [PasienController::class, 'showByUser'])->name('pasien.showByUser');
    Route::get('/pasien/{id}/print-rekam-medis', [PasienController::class, 'printRekamMedis'])
        ->name('pasien.printRekamMedis');
});

Route::middleware(['auth', 'role.dokter'])->group(function () {
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.dashboard');

    Route::get('rekam-medis/{pasienId}', [RekamMedisController::class, 'show'])->name('rekam_medis.show');
    Route::resource('rekam-medis-management', RekamMedisController::class);
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');
    Route::post('antrian', [UserController::class, 'create'])->name('antrian.create');

    Route::get('rekam-medis-pasien', [RekamMedisUserController::class, 'index'])->name('rekam_medis_pasien.index');
});

Route::get('/cronjob/reset-antrian', [CronJobController::class, 'resetAntrian'])->name('cronjob.reset-antrian');
