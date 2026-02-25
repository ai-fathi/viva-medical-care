<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // يمكنك تغيير اسم المستخدم وكلمة المرور هنا
        $adminUser = 'viva_admin'; 
        $adminPass = 'viva2026_secure'; 

        if ($request->getUser() != $adminUser || $request->getPassword() != $adminPass) {
            $headers = ['WWW-Authenticate' => 'Basic realm="Admin Login"'];
            return response('Unauthorized', 401, $headers);
        }

        return $next($request);
    }
}
