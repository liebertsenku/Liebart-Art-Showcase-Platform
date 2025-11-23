<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload New Artwork - LiebArt</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F5F4F2] text-gray-900">

    <nav class="w-full bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-black rounded text-white flex items-center justify-center font-bold">L</div>
                    <span class="font-bold text-xl tracking-tight">LiebArt</span>
                </a>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">Hi, {{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12 px-4 sm:px-6">
        <div class="max-w-3xl mx-auto">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Upload Artwork</h1>
                <p class="text-gray-500 mt-2">Showcase your creativity to the world.</p>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm p-8 sm:p-10 border border-gray-100">
                
                <form action="{{ route('member.artworks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-8" x-data="{ imagePreview: null }">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Artwork File</label>
                        
                        <div class="relative w-full h-80 rounded-2xl bg-[#F5F4F2] border-2 border-dashed border-gray-300 hover:border-black transition flex flex-col items-center justify-center overflow-hidden cursor-pointer group">
                            
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                   required accept="image/*"
                                   @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                            
                            <div class="text-center p-6 transition-opacity duration-300" :class="{ 'opacity-0 hidden': imagePreview }">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                </div>
                                <p class="text-gray-900 font-medium">Click or drag image here</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG (Max 5MB)</p>
                            </div>

                            <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-contain p-4" style="display: none;">
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 font-medium text-lg"
                            placeholder="e.g. The Lost City">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category</label>
                            <div class="relative">
                                <select name="category_id" required class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 appearance-none">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags') }}"
                                class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                placeholder="Digital, Abstract, 3D (Comma separated)">
                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="5" required
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 leading-relaxed"
                            placeholder="Tell the story behind your artwork..."></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                        <a href="{{ url()->previous() }}" class="text-sm font-medium text-gray-500 hover:text-black transition">Cancel</a>
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Upload Artwork
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>