<?php

use Illuminate\Support\Facades\Route;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome'); // تأكد من وجود resources/views/welcome.blade.php
});

/*
|--------------------------------------------------------------------------
| تسجيل الدخول والخروج للـ Admin
|--------------------------------------------------------------------------
*/
// صفحة تسجيل الدخول
Route::get('/admin-login', function () {
    return view('admin-login'); // تأكد من وجود resources/views/admin-login.blade.php
})->name('admin.login');

// تسجيل الدخول
Route::post('/admin-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return back()->withErrors(['email' => 'الإيميل أو كلمة المرور خاطئة']);
    }

    $request->session()->put('admin_id', $admin->id);
    $request->session()->put('admin_name', $admin->name);

    return redirect('/dashboard');
});

// تسجيل الخروج
Route::get('/admin-logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/admin-login');
})->name('admin.logout');

/*
|--------------------------------------------------------------------------
| لوحة التحكم والعمليات المرتبطة بالمواعيد
|--------------------------------------------------------------------------
*/
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/update', [AppointmentController::class, 'update'])->name('appointments.update');
});

/*
|--------------------------------------------------------------------------
| تغيير اللغة
|--------------------------------------------------------------------------
*/
Route::get('/language/{locale}', [AppointmentController::class, 'changeLanguage'])->name('lang.switch');

/*
|--------------------------------------------------------------------------
| استقبال وحفظ طلبات المواعيد من المرضى
|--------------------------------------------------------------------------
*/
Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/check', [AppointmentController::class, 'checkStatus'])->name('appointments.check');
