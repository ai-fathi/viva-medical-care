<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/run-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return "Migration finished successfully!";
});
// --- المسارات العامة (للمرضى) ---
Route::get('/', function () { 
    return view('welcome'); 
});

// مسارات المريض - لاحظ استخدام checkStatus هنا ليتوافق مع الـ Controller الخاص بك
Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/check', [AppointmentController::class, 'checkStatus'])->name('appointments.check');

// مسار تغيير اللغة
Route::get('/lang/{locale}', [AppointmentController::class, 'changeLanguage'])->name('lang.switch');


// --- المسارات المحمية (لوحة تحكم العيادة) ---
// لا يمكن الدخول هنا إلا باستخدام اسم المستخدم وكلمة السر
Route::middleware(['admin.auth'])->group(function () {
    
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/update', [AppointmentController::class, 'update'])->name('appointments.update');
    
});

Route::get('/init-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate --force');
        return "Success! Database tables created: " . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
