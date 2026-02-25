<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocal
{
    /**
     * هذا الكود هو المسؤول عن قراءة اللغة المختارة وتطبيقها على الموقع
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من وجود اللغة في الجلسة (Session)
        if (session()->has('locale')) {
            // تطبيق اللغة المختارة (ar, en, fr) على النظام
            App::setLocale(session()->get('locale'));
        }
        
        return $next($request);
    }
}