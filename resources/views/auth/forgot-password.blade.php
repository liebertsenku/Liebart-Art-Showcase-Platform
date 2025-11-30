<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
        <div class="text-sm text-gray-500 mt-2 leading-relaxed">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 gap-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-black transition-colors">
                Back to Login
            </a>
            <button type="submit" class="bg-black text-white font-medium rounded-lg px-6 py-3 hover:bg-gray-800 transition duration-200">
                Email Password Reset Link
            </button>
        </div>
    </form>
</x-guest-layout>