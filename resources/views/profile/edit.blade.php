<x-app-layout>
    <div class="min-h-screen bg-[#F5F4F2] py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
                <p class="text-gray-500 mt-2">Update your public information and account settings.</p>
            </div>

            <!-- Form Card: Profile Information -->
            <div class="bg-white rounded-[24px] shadow-sm p-8 sm:p-10 border border-gray-100">
                
                <!-- Status Message -->
                @if (session('status') === 'profile-updated')
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl flex items-center gap-2 text-sm font-medium" 
                         x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Profile updated successfully.
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- 1. FOTO PROFIL -->
                    <div x-data="{ photoName: null, photoPreview: null }">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Profile Photo</label>
                        
                        <!-- Input File Hidden -->
                        <input type="file" class="hidden" x-ref="photo" name="photo"
                                @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " />

                        <div class="flex items-center gap-6">
                            <!-- Foto Saat Ini -->
                            <div class="mt-2" x-show="! photoPreview">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="rounded-full h-20 w-20 object-cover border-2 border-gray-100">
                                @else
                                    <div class="h-20 w-20 rounded-full bg-black flex items-center justify-center text-white text-2xl font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Preview Foto Baru -->
                            <div class="mt-2" x-show="photoPreview" style="display: none;">
                                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center border-2 border-gray-100"
                                      :style="'background-image: url(\'' + photoPreview + '\');'">
                                </span>
                            </div>

                            <button type="button" class="bg-white border border-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg hover:bg-gray-50 transition text-sm"
                                    x-on:click.prevent="$refs.photo.click()">
                                Change Photo
                            </button>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                    </div>

                    <!-- 2. NAMA -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Display Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 font-medium">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- 3. EMAIL -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2">
                                <p class="text-sm text-gray-800">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- 4. BIO -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bio</label>
                        <textarea name="bio" rows="4"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 leading-relaxed placeholder-gray-400"
                            placeholder="Tell a bit about yourself...">{{ old('bio', $user->bio) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>

                    <!-- 5. SOCIAL LINKS -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Instagram -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Instagram</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-transparent bg-gray-100 text-gray-500 text-sm">@</span>
                                <input type="text" name="instagram" value="{{ old('instagram', $user->instagram) }}"
                                    class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-r-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                    placeholder="username">
                            </div>
                        </div>

                        <!-- Behance -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Behance</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-transparent bg-gray-100 text-gray-500 text-sm">Be</span>
                                <input type="text" name="behance" value="{{ old('behance', $user->behance) }}"
                                    class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-r-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                    placeholder="username">
                            </div>
                        </div>

                        <!-- Website -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Website</label>
                            <input type="url" name="website" value="{{ old('website', $user->website) }}"
                                class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                placeholder="https://yourportfolio.com">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 pt-6 border-t border-gray-100 mt-6">
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Save Changes
                        </button>
                        
                        <a href="{{ route('member.show', Auth::id()) }}" class="text-sm font-bold text-gray-500 hover:text-black transition">
                            View Public Profile &rarr;
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Form Card: Update Password -->
            <div class="mt-8 bg-white rounded-[24px] shadow-sm p-8 sm:p-10 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Security</h3>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Form Card: Delete Account -->
            <div class="mt-8 bg-white rounded-[24px] shadow-sm p-8 sm:p-10 border border-gray-100">
                <h3 class="text-lg font-bold text-red-600 mb-6">Danger Zone</h3>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>