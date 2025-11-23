<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Set New Password</h2>
        <p class="text-gray-500 text-sm mt-2">Create a new secure password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-black text-white font-medium rounded-lg px-4 py-3.5 hover:bg-gray-800 transition duration-200 shadow-lg shadow-gray-200">
            Reset Password
        </button>
    </form>
</x-guest-layout>