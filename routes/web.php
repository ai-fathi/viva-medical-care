<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| تغيير اللغة
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', [AppointmentController::class, 'changeLanguage']);

/*
|--------------------------------------------------------------------------
| تسجيل دخول المدير
|--------------------------------------------------------------------------
*/

Route::get('/admin-login', function () {
    return view('admin-login');
});

Route::post('/admin-login', function (Request $request) {

    $admin = Admin::first();

    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return back()->withErrors(['password' => 'كلمة المرور خاطئة']);
    }

    $request->session()->put('admin_id', $admin->id);
    $request->session()->put('admin_name', $admin->name);

    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| تسجيل الخروج
|--------------------------------------------------------------------------
*/

Route::get('/admin-logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/admin-login');
});

/*
|--------------------------------------------------------------------------
| لوحة التحكم
|--------------------------------------------------------------------------
*/

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'index']);
});
