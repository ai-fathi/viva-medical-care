<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| مسارات الإصلاح (قم بحذفها بعد الاستخدام بنجاح)
|--------------------------------------------------------------------------
*/

// 1. مسار إنشاء جداول قاعدة البيانات
Route::get('/run-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "تم إنشاء الجداول بنجاح! المخرجات: " . Artisan::output();
    } catch (\Exception $e) {
        return "خطأ أثناء التهجير: " . $e->getMessage();
    }
});

// 2. مسار إنشاء حساب المدير الأول لتتمكن من دخول الـ Dashboard
Route::get('/create-admin', function () {
    try {
        // تأكد من أن جدول users تم إنشاؤه أولاً عبر رابط run-migrate
        $user = User::updateOrCreate(
            ['email' => 'admin@viva.com'], // البريد الإلكتروني للدخول
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123456'), // كلمة السر للدخول
            ]
        );
        return "تم إنشاء حساب المدير بنجاح! الإيميل: admin@viva.com | الباسورد: admin123456";
    } catch (\Exception $e) {
        return "خطأ أثناء إنشاء الحساب: " . $e->getMessage();
    }
});


/*
|--------------------------------------------------------------------------
| المسارات العامة (للمرضى)
|--------------------------------------------------------------------------
*/

Route::get('/', function () { 
    return view('welcome'); 
});

Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/check', [AppointmentController::class, 'checkStatus'])->name('appointments.check');
Route::get('/lang/{locale}', [AppointmentController::class, 'changeLanguage'])->name('lang.switch');


/*
|--------------------------------------------------------------------------
| المسارات المحمية (لوحة تحكم العيادة)
|--------------------------------------------------------------------------
*/

Route::middleware(['admin.auth'])->group(function () {
    // رابط لوحة التحكم الأساسي
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/update', [AppointmentController::class, 'update'])->name('appointments.update');
});
