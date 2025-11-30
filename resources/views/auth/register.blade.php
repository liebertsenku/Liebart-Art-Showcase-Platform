<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Create account</h2>
        <p class="text-gray-500 text-sm mt-1">Join as a Member or apply as a Curator.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ role: '{{ old('role', 'member') }}' }">
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
                <select id="role" name="role" x-model="role" required
                    class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 text-gray-900 appearance-none transition-all cursor-pointer">
                    <option value="member">Member (Creator / Viewer)</option>
                    <option value="curator">Curator (Reviewer)</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div x-show="role === 'curator'" x-transition.opacity class="border-l-4 border-black pl-4 my-6 space-y-5">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Curator Application Details</h3>
            
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Organization / Community</label>
                <input type="text" name="organization_name" value="{{ old('organization_name') }}" 
                    class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black placeholder-gray-400" placeholder="e.g. Jakarta Art Collective">
                <x-input-error :messages="$errors->get('organization_name')" class="mt-1" />
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Portfolio / LinkedIn URL</label>
                <input type="url" name="portfolio_link" value="{{ old('portfolio_link') }}" 
                    class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black placeholder-gray-400" placeholder="https://linkedin.com/in/...">
                <x-input-error :messages="$errors->get('portfolio_link')" class="mt-1" />
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Why do you want to be a curator?</label>
                <textarea name="reason_for_applying" rows="3" 
                    class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black placeholder-gray-400">{{ old('reason_for_applying') }}</textarea>
                <x-input-error :messages="$errors->get('reason_for_applying')" class="mt-1" />
            </div>
        </div>
        <div class="mb-5" x-data="{ show: false }">
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                    class="w-full bg-[#F3F3F3] border-transparent focus:border-black focus:ring-0 rounded-lg px-4 py-3 pr-12 text-gray-900 placeholder-gray-500 transition-all">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-black focus:outline-none">
                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
            </div>
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