<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UnitLayananController;
use App\Http\Controllers\Backend\DataObatController;
use App\Http\Controllers\Backend\SatuanObatController;
use App\Http\Controllers\Backend\TransaksionalController;
use App\Http\Controllers\Backend\HistoriTransaksionalController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\GudangController;
use App\Http\Controllers\Backend\PesertaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\QrCodeController;
use App\Http\Controllers\LandingPageController;
use App\Models\Peserta;

Route::get('/', [LandingPageController::class, 'index'])->name('welcome');
Route::get('/download-qrcode/{id}', [LandingPageController::class, 'download'])->name('download.qrcode');

// Autentikasi
Route::get('login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Backend Group
Route::prefix('backend')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

    // Generate QR Code
    Route::post('/qr-code/store', [DashboardController::class, 'store'])->name('qrCode.store');


    /** Role Permission */
    Route::resource('roles', RoleController::class);

    // Gudang
    Route::resource('gudang', GudangController::class);


    // Satuan Obat
    Route::get('/satuan-obat', [SatuanObatController::class, 'index'])->name('m_satuan_obat');
    Route::get('/satuan-obat/json', [SatuanObatController::class, 'getData'])->name('obat.data');
    Route::get('/satuan-obat/create', [SatuanObatController::class, 'create'])->name('satuan-obat.create');
    Route::post('/satuan-obat/store', [SatuanObatController::class, 'store'])->name('satuan-obat.store');
    Route::get('/satuan-obat/edit/{id}', [SatuanObatController::class, 'edit'])->name('satuan-obat.edit');
    Route::put('/satuan-obat/update/{id}', [SatuanObatController::class, 'update'])->name('satuan-obat.update');
    Route::delete('/satuan-obat/destroy/{id}', [SatuanObatController::class, 'destroy'])->name('satuan-obat.destroy');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Unit Layanan
    Route::prefix('unit_layanan')->group(function () {
        Route::get('/', [UnitLayananController::class, 'index'])->name('unit_layanan.index');
        Route::get('/create', [UnitLayananController::class, 'create'])->name('unit_layanan.create');
        Route::post('/', [UnitLayananController::class, 'store'])->name('unit_layanan.store');
        Route::get('/{unit_layanan}/edit', [UnitLayananController::class, 'edit'])->name('unit_layanan.edit');
        Route::put('/{unit_layanan}', [UnitLayananController::class, 'update'])->name('unit_layanan.update');
        Route::delete('/{unit_layanan}', [UnitLayananController::class, 'destroy'])->name('unit_layanan.destroy');
    });

    // Transaksional
    Route::prefix('transaksional')->group(function () {
        Route::get('/', [TransaksionalController::class, 'index'])->name('transaksional.index');
        Route::get('/create', [TransaksionalController::class, 'create'])->name('transaksional.create');
        Route::post('/', [TransaksionalController::class, 'store'])->name('transaksional.store');
        Route::get('/transaksional/{id}', [TransaksionalController::class, 'show'])->name('transaksional.show');
        Route::get('/{transaksional}/edit', [TransaksionalController::class, 'edit'])->name('transaksional.edit');
        Route::post('/{id}', [TransaksionalController::class, 'update'])->name('transaksional.update');
        Route::delete('/backend/transaksional/{id}', [TransaksionalController::class, 'destroy'])->name('transaksional.destroy');
        Route::post('/update-status/{id}', [TransaksionalController::class, 'updateStatus'])->name('transaksional.update-status');
    });

    // Histori Transaksional
    Route::prefix('histori-transaksional')->group(function () {
        Route::get('/', [HistoriTransaksionalController::class, 'index'])->name('histori.transaksional.index');
        Route::get('/export-pdf', [HistoriTransaksionalController::class, 'exportPdf'])->name('histori.exportPdf');
    });

    // Data Obat
    Route::prefix('data-obat')->group(function () {
        Route::get('/', [DataObatController::class, 'index'])->name('data_obat.index');
        Route::get('/create', [DataObatController::class, 'create'])->name('data_obat.create');
        Route::post('/', [DataObatController::class, 'store'])->name('data_obat.store');
        Route::get('/{id}/edit', [DataObatController::class, 'edit'])->name('data_obat.edit');
        Route::put('/{id}', [DataObatController::class, 'update'])->name('data_obat.update');
        Route::put('/update-stok/{id}', [DataObatController::class, 'updateStok'])->name('update.stok.obat');
        Route::get('/{id}', [DataObatController::class, 'show'])->name('data_obat.show');
        Route::delete('/{id}', [DataObatController::class, 'destroy'])->name('data_obat.destroy');
    });

    // Data Peserta
    Route::prefix('peserta')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('peserta.index');
        Route::get('/create', [PesertaController::class, 'create'])->name('peserta.create');
        Route::post('/', [PesertaController::class, 'store'])->name('peserta.store');
        Route::get('/{id}/edit', [PesertaController::class, 'edit'])->name('peserta.edit');
        Route::put('/{id}', [PesertaController::class, 'update'])->name('peserta.update');
        Route::get('/{id}', [PesertaController::class, 'show'])->name('peserta.show');
        Route::delete('/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
    });

    // QR Code
    Route::prefix('qrCode')->group(function () {
        Route::get('/', [QrCodeController::class, 'index'])->name('qrCode.index');
        Route::get('/create', [QrCodeController::class, 'create'])->name('qrCode.create');
        Route::post('/', [QrCodeController::class, 'store'])->name('qrCode.store');
        Route::get('/verify/{id}', [QrCodeController::class, 'verify'])->name('qrCode.verify');
        Route::get('/show/{id}', [QrCodeController::class, 'show'])->name('qrCode.show');
        Route::get('/share/{id}', [QrCodeController::class, 'shareQrCode'])->name('qrCode.shareQrCode');
        Route::delete('/{id}', [QrCodeController::class, 'destroy'])->name('qrCode.destroy');
        Route::post('/generate', [QrCodeController::class, 'generateQrCode'])->name('qrcode.generate');
        Route::get('/data', [QrCodeController::class, 'data']);
        Route::get('/{id}/edit', [QrCodeController::class, 'edit'])->name('qrCode.edit');
        Route::put('/{id}', [QrCodeController::class, 'update'])->name('qrCode.update');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

    // Others
    Route::get('/get-users-by-unit/{unitId}', [TransaksionalController::class, 'getUsersByUnit'])->name('get.users.by.unit');
    Route::get('/stok-obat/{obatId}/stok', [TransaksionalController::class, 'getStokById']);
});


