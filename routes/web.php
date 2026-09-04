<?php

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\StaffController;
use App\Models\Letter;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grup middleware untuk RT
Route::middleware(['auth', 'role:rt'])->prefix('rt')->name('rt.')->group(function () {
    Route::get('/dashboard', [RtController::class, 'dashboard'])->name('dashboard');
    Route::get('/applications', [RtController::class, 'applications'])->name('applications');
    Route::get('/applications/{id}', [RtController::class, 'detail'])->name('application.detail');
    Route::post('/applications/{id}/approve', [RtController::class, 'approve'])->name('application.approve');
    Route::post('/applications/{id}/reject', [RtController::class, 'reject'])->name('application.reject');
});

// route rw
Route::middleware(['auth', 'role:rw'])->prefix('rw')->name('rw.')->group(function () {
    Route::get('/dashboard', [RwController::class, 'dashboard'])->name('dashboard');
    Route::get('/applications', [RwController::class, 'applications'])->name('applications');
    Route::get('/applications/{id}', [RwController::class, 'detail'])->name('application.detail');
    Route::post('/applications/{id}/approve', [RwController::class, 'approve'])->name('application.approve');
    Route::post('/applications/{id}/reject', [RwController::class, 'reject'])->name('application.reject');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/applications', [StaffController::class, 'applications'])->name('applications');
    Route::get('/applications/{id}', [StaffController::class, 'detail'])->name('application.detail');
    Route::post('/applications/{id}/process', [StaffController::class, 'process'])->name('application.process');
    Route::post('/applications/{id}/upload-surat', [StaffController::class, 'uploadSurat'])->name('application.upload-surat');
    Route::post('/applications/{id}/terbitkan', [StaffController::class, 'terbitkan'])->name('application.terbitkan');
    Route::post('/applications/{id}/reject', [StaffController::class, 'reject'])->name('application.reject');
    Route::get('/riwayat', [StaffController::class, 'riwayat'])->name('riwayat');
    Route::get('/download-dokumen/{id}/{type}', [StaffController::class, 'downloadDokumen'])->name('download.dokumen');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    // Halaman riwayat (daftar semua pengajuan)
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    // Halaman tracking/detail pengajuan (pakai {id})
    Route::get('/riwayat/{id}', [RiwayatController::class, 'tracking'])->name('riwayat.tracking');
    // Download PDF surat (pakai {id}/download)
    Route::get('/riwayat/{id}/download', [RiwayatController::class, 'download'])->name('riwayat.download');
    Route::get('/pengajuan-surat', [PengajuanSuratController::class, 'index'])->name('pengajuan-surat');
    Route::get('/pengajuan-surat/create/{serviceId?}', [PengajuanSuratController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan-surat/store', [PengajuanSuratController::class, 'store'])->name('pengajuan.store');
    Route::get('/home', [PengajuanSuratController::class, 'home'])->name('home');
});


Route::get('/test-wa', function () {
    $phoneNumber = '085756956684'; // Ganti dengan nomor HP Anda

    $wa = app(App\Services\WhatsAppService::class);
    $result = $wa->sendText(
        $phoneNumber,
        "📢 *Test WhatsApp dari SIPMAS!*\n\nIni adalah pesan test dari sistem SIPMAS Galung Maloang."
    );

    return $result ? '✅ Pesan berhasil dikirim!' : '❌ Gagal mengirim pesan.';
});



require __DIR__.'/auth.php';