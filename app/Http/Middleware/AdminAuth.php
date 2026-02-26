<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // إذا لم يكن هناك admin في session، تحقق من تسجيل دخول تلقائي
        if (!$request->session()->has('admin_id')) {

            // إنشاء الحساب الإداري تلقائياً إذا لم يكن موجود
            $admin = Admin::first();
            if (!$admin) {
                $admin = Admin::create([
                    'name' => 'Admin User',
                    'email' => 'admin@viva.com',
                    'password' => Hash::make('admin123456')
                ]);
            }

            // إذا حاول الوصول ولم يسجل دخول، أعطه redirect لتسجيل الدخول
            return redirect('/admin-login');
        }

        return $next($request);
    }
}
