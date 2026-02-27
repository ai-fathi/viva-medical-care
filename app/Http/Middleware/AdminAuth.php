<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // تحقق فقط من وجود session لمستخدم Admin
        if (!$request->session()->has('admin_id')) {
            // إذا لم يكن مسجّل دخول → أعد توجيهه لتسجيل الدخول
            return redirect('/admin-login');
        }

        return $next($request);
    }
}
