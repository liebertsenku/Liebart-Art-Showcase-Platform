<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Create account</h2>
        <p class="text-gray-500 text-sm mt-1">Join our art showcase platform.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-black text-white font-medium rounded-lg px-4 py-3.5 hover:bg-gray-800 transition duration-200 shadow-lg shadow-gray-200">
            Sign up
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-gray-100">
        <div class="flex justify-between items-center">
            <span class="text-gray-900 font-medium text-sm">Already have an account?</span>
            
            <a href="{{ route('login') }}" class="inline-block bg-white border border-gray-200 hover:border-gray-400 text-gray-900 font-medium text-sm py-2 px-5 rounded-lg transition-colors">
                Log in
            </a>
        </div>
    </div>
</x-guest-layout>