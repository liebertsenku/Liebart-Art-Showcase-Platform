<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Back -->
            <div class="mb-8">
                <a href="{{ route('curator.challenges.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-black mb-4 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Challenges
                </a>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Create New Challenge</h1>
                <p class="text-gray-500 mt-1">Set up the theme, rules, and timeline.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-[24px] shadow-sm p-8 border border-gray-100">
                <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Challenge Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required autofocus
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 font-medium text-lg"
                            placeholder="e.g. Cyberpunk Cityscapes 2025">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="4" required
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 leading-relaxed"
                            placeholder="Explain the theme and what you are looking for...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Start Date</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" required
                                class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900">
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">End Date</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" required
                                class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900">
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Rules -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Rules & Guidelines</label>
                        <textarea name="rules" rows="4" required
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                            placeholder="- Original work only&#10;- No AI generated art&#10;- Must include source files">{{ old('rules') }}</textarea>
                        <x-input-error :messages="$errors->get('rules')" class="mt-2" />
                    </div>

                    <!-- Prizes -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Prizes (Optional)</label>
                        <textarea name="prizes" rows="2"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                            placeholder="1st Place: Feature on homepage...">{{ old('prizes') }}</textarea>
                    </div>

                    <!-- Banner Image -->
                    <div x-data="{ bannerPreview: null }">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Cover Banner</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-[#F5F4F2] hover:bg-gray-200 transition overflow-hidden">
                                
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!bannerPreview">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-sm text-gray-500"><span class="font-semibold text-black">Click to upload</span> banner</p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG (Max. 2MB)</p>
                                </div>

                                <img x-show="bannerPreview" :src="bannerPreview" class="absolute inset-0 w-full h-full object-cover" style="display: none;">
                                
                                <input id="dropzone-file" type="file" name="banner_image" class="hidden" accept="image/*"
                                    @change="bannerPreview = URL.createObjectURL($event.target.files[0])" 
                                    required />
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('banner_image')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Publish Challenge
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>