<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Secure Area</h2>
        <div class="text-sm text-gray-500 mt-2">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <button type="submit" class="w-full bg-black text-white font-medium rounded-lg px-4 py-3.5 hover:bg-gray-800 transition duration-200 shadow-lg shadow-gray-200">
                Confirm
            </button>
        </div>
    </form>
</x-guest-layout>