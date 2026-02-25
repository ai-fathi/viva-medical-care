<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('لوحة التحكم - عيادة فيفا') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <div class="min-h-screen">
        <nav class="bg-white dark:bg-gray-800 shadow-md p-4 flex justify-between items-center sticky top-0 z-50">
            <h1 class="text-xl font-bold text-blue-600 flex items-center gap-2">
                <span>🏥</span> {{ __('إدارة مواعيد عيادة فيفا') }}
            </h1>
            <div class="flex items-center gap-4">
                <div class="flex gap-2 mr-4">
                    <a href="{{ url('lang/ar') }}" class="text-xs {{ app()->getLocale() == 'ar' ? 'font-bold text-blue-600' : '' }}">AR</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ url('lang/fr') }}" class="text-xs {{ app()->getLocale() == 'fr' ? 'font-bold text-blue-600' : '' }}">FR</a>
                </div>
                <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full hover:scale-110 transition">🌙</button>
                <a href="/" class="text-sm bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 px-4 py-2 rounded-lg hover:bg-blue-100 transition">{{ __('الموقع الرئيسي') }}</a>
            </div>
        </nav>

        <div class="container mx-auto py-8 px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg transform hover:scale-105 transition">
                    <p class="text-sm opacity-80">{{ __('إجمالي الطلبات') }}</p>
                    <p class="text-3xl font-bold">{{ $appointments->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-6 rounded-2xl shadow-lg transform hover:scale-105 transition">
                    <p class="text-sm opacity-80">{{ __('طلبات قيد الانتظار') }}</p>
                    <p class="text-3xl font-bold">{{ $appointments->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-lg transform hover:scale-105 transition">
                    <p class="text-sm opacity-80">{{ __('مواعيد مؤكدة') }}</p>
                    <p class="text-3xl font-bold">{{ $appointments->where('status', 'confirmed')->count() }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-lg font-bold">{{ __('قائمة المواعيد الأخيرة') }}</h2>
                    <span class="text-xs text-gray-500 italic">{{ __('تحديث تلقائي للمنصة') }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-300 uppercase text-xs font-bold">
                                <th class="p-4">{{ __('المريض') }}</th>
                                <th class="p-4">{{ __('بيانات الاتصال') }}</th>
                                <th class="p-4">{{ __('نوع العلاج') }}</th>
                                <th class="p-4">{{ __('التاريخ المطلوب') }}</th>
                                <th class="p-4 text-center">{{ __('الحالة') }}</th>
                                <th class="p-4">{{ __('تحديد الموعد النهائي') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @forelse($appointments as $appointment)
                            <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition">
                                <td class="p-4">
                                    <div class="font-bold text-gray-800 dark:text-gray-200">
                                        {{ $appointment->first_name }} {{ $appointment->last_name }}
                                    </div>
                                    <span class="text-[10px] text-gray-400">ID: #{{ $appointment->id }}</span>
                                </td>

                                <td class="p-4 text-sm">
                                    <div class="flex flex-col">
                                        <span class="font-mono text-blue-600 dark:text-blue-400">{{ $appointment->phone }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $appointment->email ?? __('لا يوجد بريد') }}</span>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                        {{ __($appointment->treatment_type) }} </span>
                                </td>

                                <td class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    {{ $appointment->preferred_date }}
                                </td>

                                <td class="p-4 text-center">
                                    @if($appointment->status == 'pending')
                                        <span class="bg-orange-100 text-orange-600 text-[11px] font-bold px-3 py-1 rounded-full border border-orange-200">{{ __('قيد الانتظار') }}</span>
                                    @else
                                        <span class="bg-green-100 text-green-600 text-[11px] font-bold px-3 py-1 rounded-full border border-green-200">{{ __('تم التأكيد') }}</span>
                                    @endif
                                </td>

                                <td class="p-4">
                                    @if($appointment->status == 'pending')
                                        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <input type="datetime-local" name="scheduled_at" required 
                                                class="border border-gray-300 rounded-lg p-1.5 text-xs dark:bg-gray-700 dark:border-gray-600 outline-none focus:ring-2 focus:ring-blue-500">
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-md">
                                                {{ __('تأكيد') }}
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-400 italic">{{ __('الموعد المحجوز:') }}</span>
                                            <span class="text-sm font-mono text-green-600 dark:text-green-400 font-bold">
                                                {{ $appointment->scheduled_at ? \Carbon\Carbon::parse($appointment->scheduled_at)->format('Y-m-d H:i') : '--' }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <span class="text-5xl mb-3">📁</span>
                                        <p>{{ __('لا توجد طلبات مواعيد مسجلة حالياً.') }}</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <footer class="mt-8 text-center text-gray-500 text-xs">
                &copy; 2026 {{ ('VIVA MEDICAL CARE') }} - {{ ('جميع الحقوق محفوظة لنظام الإدارة الاحترافي') }}
            </footer>
        </div>
    </div>

</body>
</html>