<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. إجبار استخدام HTTPS في بيئة الرفع (Render) لمنع تحذيرات الأمان
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // 2. تطبيق اللغة المختارة من الجلسة تلقائياً عند كل طلب
        // هذا يضمن أن الترجمة تعمل وتستمر عند التنقل بين الصفحات
        view()->composer('*', function ($view) {
            if (Session::has('locale')) {
                App::setLocale(Session::get('locale'));
            }
        });
    }
}
