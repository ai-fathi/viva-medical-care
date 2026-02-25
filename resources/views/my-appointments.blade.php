@if($appointments)
    @foreach($appointments as $app)
        <div class="p-5 mb-4 border-l-4 {{ $app->status == 'مقبول' ? 'border-green-500' : 'border-yellow-500' }} bg-gray-50 dark:bg-gray-800 rounded-lg">
            <div class="flex justify-between">
                <span class="font-bold">{{ $app->patient_name }}</span>
                <span class="text-xs uppercase px-2 py-1 rounded {{ $app->status == 'مقبول' ? 'bg-green-100' : 'bg-yellow-100' }}">
                    {{ __($app->status) }}
                </span>
            </div>
            <div class="mt-2 text-sm">
                <p><i class="fas fa-calendar"></i> {{ $app->date }}</p>
                @if($app->status == 'مقبول')
                    <p class="text-green-600 font-bold mt-1">
                        <i class="fas fa-clock"></i> {{ __('Confirmed Time') }}: {{ $app->time }}
                    </p>
                @else
                    <p class="text-gray-400 italic">{{ __('Time will be assigned soon') }}</p>
                @endif
            </div>
        </div>
    @endforeach
@endif