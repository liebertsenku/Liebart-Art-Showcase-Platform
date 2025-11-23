<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Artwork - LiebArt</title>
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
            
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Artwork</h1>
                    <p class="text-gray-500 mt-2">Update details for "{{ $artwork->title }}"</p>
                </div>
                
                <form action="{{ route('member.artworks.destroy', $artwork->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this artwork?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 text-sm font-medium hover:text-red-700 underline decoration-red-200 underline-offset-4">
                        Delete Artwork
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm p-8 sm:p-10 border border-gray-100">
                
                <form action="{{ route('member.artworks.update', $artwork->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="mb-8" x-data="{ imagePreview: '{{ $artwork->image ? asset('storage/' . $artwork->image) : '' }}' }">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Artwork Image</label>
                        
                        <div class="relative w-full h-80 rounded-2xl bg-[#F5F4F2] border-2 border-dashed border-gray-300 hover:border-black transition flex flex-col items-center justify-center overflow-hidden cursor-pointer group">
                            
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                   accept="image/*"
                                   @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                            
                            <div class="text-center p-6" x-show="!imagePreview">
                                <p class="text-gray-500">No image selected</p>
                            </div>

                            <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-contain p-4 bg-gray-100/50">
                            
                            <div class="absolute bottom-4 bg-black/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm opacity-0 group-hover:opacity-100 transition">
                                Change Image
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $artwork->title) }}" required
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 font-medium text-lg">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category</label>
                            <div class="relative">
                                <select name="category_id" required class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 appearance-none">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $artwork->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tags</label>
                            @php
                                $tagsValue = '';
                                if (isset($artwork->tags)) {
                                    // Cek apakah sudah array (karena casts) atau masih string
                                    $tagsArray = is_array($artwork->tags) ? $artwork->tags : json_decode($artwork->tags, true);
                                    if(is_array($tagsArray)) {
                                        $tagsValue = implode(', ', $tagsArray);
                                    }
                                }
                            @endphp
                            
                            <input type="text" name="tags" value="{{ old('tags', $tagsValue) }}"
                                class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900"
                                placeholder="Digital, Abstract (Comma separated)">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="5" required
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 leading-relaxed">{{ old('description', $artwork->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('member.artworks.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition">Cancel</a>
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Update Artwork
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>