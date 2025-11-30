<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Apply as Curator</h2>
        <p class="text-gray-500 text-sm mt-1">Host challenges and discover talents.</p>
    </div>

    <form method="POST" action="{{ route('curator.register.store') }}">
        @csrf

        <!-- Personal Info -->
        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Account Info</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">
            </div>
        </div>

        <!-- Professional Info -->
        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Curator Profile</h3>

        <div class="mb-4">
            <label class="block text-xs font-bold text-gray-500 mb-1">Organization / Community Name</label>
            <input type="text" name="organization_name" value="{{ old('organization_name') }}" required class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">
            <x-input-error :messages="$errors->get('organization_name')" class="mt-1" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Website (Optional)</label>
                <input type="url" name="organization_website" value="{{ old('organization_website') }}" class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Portfolio / Social Media Link</label>
                <input type="url" name="portfolio_link" value="{{ old('portfolio_link') }}" class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-xs font-bold text-gray-500 mb-1">Why do you want to be a curator?</label>
            <textarea name="reason_for_applying" rows="3" required class="w-full bg-[#F3F3F3] border-transparent rounded-lg focus:ring-black">{{ old('reason_for_applying') }}</textarea>
            <x-input-error :messages="$errors->get('reason_for_applying')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-black">Already registered?</a>
            <button type="submit" class="bg-black text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-800 transition">
                Submit Application
            </button>
        </div>
    </form>
</x-guest-layout>