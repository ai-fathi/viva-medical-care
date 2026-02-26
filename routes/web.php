<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// رابط تجريبي للتأكد من عمل المسارات
Route::get('/test-link', function () {
    return "The routes are working correctly!";
});

// 1. مسار إنشاء الجداول
Route::get('/force-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Success! Tables created: " . Artisan::output();
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// 2. مسار إنشاء المدير
Route::get('/force-admin', function () {
    try {
        $user = User::updateOrCreate(
            ['email' => 'admin@viva.com'],
            ['name' => 'Admin', 'password' => Hash::make('admin123456')]
        );
        return "Admin Created Successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// --- المسارات الأصلية ---
Route::get('/', function () { return view('welcome'); });
Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/check', [AppointmentController::class, 'checkStatus'])->name('appointments.check');
Route::get('/lang/{locale}', [AppointmentController::class, 'changeLanguage'])->name('lang.switch');

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/update', [AppointmentController::class, 'update'])->name('appointments.update');
});
