<form action="{{ route('appointments.store') }}" method="POST" class="space-y-4">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label>{{ __('First Name') }}</label>
            <input type="text" name="name" required class="w-full p-3 rounded-xl border shadow-sm">
        </div>
        <div>
            <label>{{ __('Last Name') }}</label>
            <input type="text" name="lastname" required class="w-full p-3 rounded-xl border shadow-sm">
        </div>
    </div>
    <div>
        <label>{{ __('Phone Number') }}</label>
        <input type="tel" name="phone" required class="w-full p-3 rounded-xl border shadow-sm">
    </div>
    <div>
        <label>{{ __('Preferred Date') }}</label>
        <input type="date" name="date" required class="w-full p-3 rounded-xl border shadow-sm">
    </div>
    <button type="submit" class="w-full bg-blue-600 text-white p-4 rounded-2xl font-bold">
        {{ __('Confirm Booking') }}
    </button>
</form>