<x-app-layout>
    <div class="min-h-screen bg-[#F5F4F2] py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
                <p class="text-gray-500 mt-2">Update your personal information.</p>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm p-8 sm:p-10 border border-gray-100">
                
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

                    <div x-data="{ photoName: null, photoPreview: null }">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Profile Photo</label>
                        
                        <input type="file" class="hidden" x-ref="photo" name="photo"
                                @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " />

                        <div class="flex items-center gap-6">
                            <div class="mt-2" x-show="! photoPreview">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="rounded-full h-20 w-20 object-cover border-2 border-gray-100">
                                @else
                                    <div class="h-20 w-20 rounded-full bg-black flex items-center justify-center text-white text-2xl font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

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

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Display Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 font-medium">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bio</label>
                        <textarea name="bio" rows="4"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 leading-relaxed placeholder-gray-400"
                            placeholder="Tell a bit about yourself...">{{ old('bio', $user->bio) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>

                    <div class="flex items-center gap-4 pt-6 border-t border-gray-100 mt-6">
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Save Changes
                        </button>
                        <a href="{{ route('profile.show', Auth::id()) }}" class="text-sm font-medium text-gray-500 hover:text-black transition">
                            View Public Profile
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>