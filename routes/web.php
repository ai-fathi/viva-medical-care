<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| مسارات الإصلاح السريع
|--------------------------------------------------------------------------
*/

Route::get('/force-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "تم إنشاء الجداول بنجاح! المخرجات: " . Artisan::output();
    } catch (\Exception $e) {
        return "حدث خطأ أثناء الميجرشن: " . $e->getMessage();
    }
});

Route::get('/force-admin', function () {
    try {
        User::updateOrCreate(
            ['email' => 'admin@viva.com'],
            ['name' => 'Admin User', 'password' => Hash::make('admin123456')]
        );
        return "تم إنشاء الحساب! الإيميل: admin@viva.com | الباسورد: admin123456";
    } catch (\Exception $e) {
        return "حدث خطأ أثناء إنشاء الحساب: " . $e->getMessage();
    }
});

/*
|--------------------------------------------------------------------------
| مسارات التطبيق المعدلة
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية مع تطبيق اللغة من الجلسة
Route::get('/', function () { 
    if (Session::has('locale')) {
        App::setLocale(Session::get('locale'));
    }
    return view('welcome'); 
});

Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/check', [AppointmentController::class, 'checkStatus'])->name('appointments.check');

// تغيير المسار هنا لتجنب التعارض مع مجلد lang
Route::get('/language/{locale}', [AppointmentController::class, 'changeLanguage'])->name('lang.switch');

// لوحة التحكم
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/update', [AppointmentController::class, 'update'])->name('appointments.update');
});
