<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| مسارات الإصلاح السريع (استخدمها بالترتيب)
|--------------------------------------------------------------------------
*/

// 1. رابط تشغيل قاعدة البيانات: /force-migrate
Route::get('/force-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "تم إنشاء الجداول بنجاح! المخرجات: " . Artisan::output();
    } catch (\Exception $e) {
        return "حدث خطأ أثناء الميجرشن: " . $e->getMessage();
    }
});

// 2. رابط إنشاء حساب المدير: /force-admin
Route::get('/force-admin', function () {
    try {
        $user = User::updateOrCreate(
            ['email' => 'admin@viva.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123456'),
            ]
        );
        return "تم إنشاء الحساب! الإيميل: admin@viva.com | الباسورد: admin123456";
    } catch (\Exception $e) {
        return "حدث خطأ أثناء إنشاء الحساب: " . $e->getMessage();
    }
});

// رابط اختبار للتأكد من عمل الروابط: /check-test
Route::get('/check-test', function () {
    return "الروابط الآن تعمل بشكل صحيح!";
});

/*
|--------------------------------------------------------------------------
| مسارات التطبيق الأصلية
|--------------------------------------------------------------------------
*/

Route::get('/', function () { 
    return view('welcome'); 
});

Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/check', [AppointmentController::class, 'checkStatus'])->name('appointments.check');
Route::get('/lang/{locale}', [AppointmentController::class, 'changeLanguage'])->name('lang.switch');

// لوحة التحكم
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/update', [AppointmentController::class, 'update'])->name('appointments.update');
});
