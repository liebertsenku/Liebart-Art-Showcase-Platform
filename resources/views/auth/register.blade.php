<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Create account</h2>
        <p class="text-gray-500 text-sm mt-1">Join as a Member or apply as a Curator.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-5">
            <label for="role" class="block text-sm font-medium text-gray-600 mb-1">I want to join as</label>
            <div class="relative">
                <select id="role" name="role" required
                    class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 appearance-none transition-all cursor-pointer">
                    <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member (Creator / Viewer)</option>
                    <option value="curator" {{ old('role') == 'curator' ? 'selected' : '' }}>Curator (Reviewer)</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mb-5" x-data="{ show: false }">
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
            <div class="relative">
                <input id="password" 
                    :type="show ? 'text' : 'password'" 
                    name="password" 
                    required 
                    autocomplete="new-password"
                    class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 pr-12 text-gray-900 placeholder-gray-500 transition-all">
                
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-black focus:outline-none transition-colors">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6" x-data="{ show: false }">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">Confirm Password</label>
            <div class="relative">
                <input id="password_confirmation" 
                    :type="show ? 'text' : 'password'" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 pr-12 text-gray-900 placeholder-gray-500 transition-all">
                
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-black focus:outline-none transition-colors">
                     <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
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