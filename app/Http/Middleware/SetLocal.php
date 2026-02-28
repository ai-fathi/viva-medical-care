<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocal
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', 'ar'); // اللغة الافتراضية عربي
        App::setLocale($locale);

        return $next($request);
    }
}
