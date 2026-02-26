use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

// صفحة تسجيل الدخول
Route::get('/admin-login', function () {
    return view('admin-login');
})->name('admin.login');

// تسجيل الدخول بدون shell
Route::post('/admin-login', function (Request $request) {
    $admin = Admin::first(); // نستخدم أول حساب
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

// لوحة التحكم
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::post('/appointments/{id}/update', [AppointmentController::class, 'update'])->name('appointments.update');
});
