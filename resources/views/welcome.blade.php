<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIVA MEDICAL CARE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <style>
        .splash-active { overflow: hidden; }
        #splash { transition: opacity 0.8s ease-out; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors h-full splash-active">

    <div id="splash" class="fixed inset-0 z-[100] bg-white dark:bg-gray-900 flex flex-col items-center justify-center">
        <div class="text-4xl font-bold text-blue-600 animate-bounce text-center">
            🏥<br>VIVA MEDICAL CARE
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-6">
        <header class="flex justify-between items-center py-6 border-b dark:border-gray-700">
            <h1 class="text-2xl font-bold text-blue-600">VIVA MEDICAL CARE</h1>
            <div class="flex gap-4">
                <select onchange="window.location.href=this.value" class="dark:bg-gray-800 border rounded px-2 py-1 outline-none">
                    <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                    <option value="{{ route('lang.switch', 'ar') }}" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
                    <option value="{{ route('lang.switch', 'fr') }}" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
                </select>
                <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 border rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">🌙</button>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-10">
            <button onclick="openModal('bookModal')" class="bg-blue-500 hover:bg-blue-600 text-white p-8 rounded-2xl shadow-lg flex flex-col items-center transition transform hover:scale-105">
                <span class="text-3xl mb-2">🗓️</span> {{ __('Book Appointment') }}
            </button>
            <button onclick="openModal('statusModal')" class="bg-green-500 hover:bg-green-600 text-white p-8 rounded-2xl shadow-lg flex flex-col items-center transition transform hover:scale-105">
                <span class="text-3xl mb-2">📋</span> {{ __('My Appointments') }}
            </button>
            <button onclick="openModal('clinicModal')" class="bg-purple-500 hover:bg-purple-600 text-white p-8 rounded-2xl shadow-lg flex flex-col items-center transition transform hover:scale-105">
                <span class="text-3xl mb-2">🏥</span> {{ __('The Clinic') }}
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12 border-t pt-10">
            <div>
                <h3 class="text-xl font-bold mb-4">{{ __('About Clinic') }}</h3>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                   {{ __('General medicine clinic in Boumerdès specializing in pain management, sports pathologies, and musculo-articular disorders. We combine modern medicine with advanced techniques to offer you effective, personalized, and safe treatment.') }}
                </p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">{{ __('Contact Us') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-2 font-medium">
                    📍 Kanagaz RN N°24 Bat H10, 2éme étage N°3 Boumerdés
                </p>
                <div class="space-y-1">
                    <p class="text-blue-600 font-bold text-lg">📞 0550 54 50 46</p>
                    <p class="text-blue-600 font-bold text-lg">📞 0774 99 75 28</p>
                </div>
                <p class="text-gray-500 mt-2">📧 vivaclinic16@gmail.com</p>
            </div>
        </div>
    </div>
    <div id="bookModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl w-full max-w-md shadow-2xl">
            <h2 class="text-2xl font-bold mb-6 text-blue-600">{{ __('New Appointment') }}</h2>
            <form action="{{ route('appointments.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="first_name" placeholder="{{ __('Name') }}" class="w-full p-3 border rounded-xl dark:bg-gray-700" required>
                    <input type="text" name="last_name" placeholder="{{ __('Surname') }}" class="w-full p-3 border rounded-xl dark:bg-gray-700" required>
                </div>
                <input type="email" name="email" placeholder="{{ __('Email (Optional)') }}" class="w-full p-3 border rounded-xl dark:bg-gray-700">
                <input type="tel" name="phone" placeholder="{{ __('Phone Number') }}" class="w-full p-3 border rounded-xl dark:bg-gray-700" required>
                <select name="treatment_type" class="w-full p-3 border rounded-xl dark:bg-gray-700" required>
                    <option value="General Medicine and Sports Pathologies">{{ __('General Medicine and Sports Pathologies') }}</option>
                    <option value="Medical Acupuncture and Mesotherapy">{{ __('Medical Acupuncture and Mesotherapy') }}</option>
                    <option value="PRP (Platelet-Rich Plasma)">{{ __('PRP (Platelet-Rich Plasma)') }}</option>
                    <option value="Manual Medicine and Osteo-articular Treatment">{{ __('Manual Medicine and Osteo-articular Treatment') }}</option>
                    <option value="Musculoskeletal Ultrasound">{{ __('Musculoskeletal Ultrasound') }}</option>
                </select>
                <input type="date" name="preferred_date" class="w-full p-3 border rounded-xl dark:bg-gray-700" required>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg transition">
                    {{ __('Confirm') }}
                </button>
            </form>
            <button onclick="closeModal('bookModal')" class="mt-4 w-full text-gray-400 text-sm">Cancel</button>
        </div>
    </div>

    <div id="statusModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl w-full max-w-md shadow-2xl">
            <h2 class="text-2xl font-bold mb-4 text-green-600">{{ __('My Appointments') }}</h2>
            <form action="{{ route('appointments.check') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex gap-2">
                    <input type="tel" name="phone" placeholder="05XXXXXXXX" class="flex-1 p-3 border rounded-xl dark:bg-gray-700" required>
                    <button type="submit" class="bg-green-600 text-white px-4 rounded-xl">🔍</button>
                </div>
            </form>

            @if(session('appointment_data'))
                @php $apt = session('appointment_data'); @endphp
                <div class="p-5 bg-blue-50 dark:bg-gray-700 rounded-2xl border-2 border-blue-200">
                    <p class="text-sm"><strong>{{ __('Status') }}:</strong> 
                        <span class="font-bold {{ $apt->status == 'confirmed' ? 'text-green-600' : 'text-orange-500' }}">
                            {{ __($apt->status) }}
                        </span>
                    </p>
                    <p class="mt-2"><strong>{{ __('Confirmed Time') }}:</strong> 
                        <span class="text-lg font-mono text-blue-700 dark:text-blue-300">
                            {{ $apt->scheduled_at ? \Carbon\Carbon::parse($apt->scheduled_at)->format('Y-m-d H:i') : __('Waiting for reception...') }}
                        </span>
                    </p>
                </div>
            @endif
            <button onclick="closeModal('statusModal')" class="mt-6 w-full text-gray-400 text-sm italic">{{ __('Close') }}</button>
        </div>
    </div>

    <div id="clinicModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl w-full max-w-2xl shadow-2xl overflow-y-auto max-h-[90vh]">
            <h2 class="text-2xl font-bold mb-6 text-purple-600">{{ __('Clinic Photos') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-2">
                @foreach(range(1, 8) as $i)
                    <div class="group relative overflow-hidden rounded-2xl shadow-md border dark:border-gray-700">
                        <img src="{{ asset('images/clinic/IMG' . $i . '.jpg') }}" alt="Clinic Photo {{ $i }}" class="w-full h-48 object-cover transform group-hover:scale-110 transition duration-500">
                    </div>
                @endforeach
            </div>
            <button onclick="closeModal('clinicModal')" class="mt-8 w-full bg-gray-200 dark:bg-gray-700 py-3 rounded-xl font-bold">Done</button>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        window.addEventListener('load', () => {
            setTimeout(() => {
                const splash = document.getElementById('splash');
                splash.style.opacity = '0';
                document.body.classList.remove('splash-active');
                setTimeout(() => splash.style.display = 'none', 800);
            }, 1500);
        });

        @if(session('appointment_data'))
            openModal('statusModal');
        @endif
    </script>
</body>
</html>
