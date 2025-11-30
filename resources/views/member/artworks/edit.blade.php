<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <a href="{{ route('member.artworks.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-black mb-4 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to My Artworks
                </a>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Artwork</h1>
                <p class="text-gray-500 mt-1">Update details for "{{ $artwork->title }}"</p>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm p-8 border border-gray-100">
                
                @if($artwork->image)
                    <div class="bg-blue-50 border border-blue-100 text-blue-800 p-4 rounded-xl flex items-center gap-3 mb-8">
                        <span class="text-2xl">🎨</span>
                        <div>
                            <h3 class="font-bold">Editing Visual Art</h3>
                            <p class="text-xs text-blue-600">This artwork includes a visual image file.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-purple-50 border border-purple-100 text-purple-800 p-4 rounded-xl flex items-center gap-3 mb-8">
                        <span class="text-2xl">📝</span>
                        <div>
                            <h3 class="font-bold">Editing Writing Piece</h3>
                            <p class="text-xs text-purple-600">This is a text-based story, poem, or article.</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('member.artworks.update', $artwork->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if($artwork->image)
                        <div x-data="{ bannerPreview: '{{ asset('storage/'.$artwork->image) }}' }">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Current Artwork Image</label>
                            
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="relative flex flex-col items-center justify-center w-full h-72 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-[#F5F4F2] hover:border-black group transition overflow-hidden">
                                    
                                    <img :src="bannerPreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                                    
                                    <div class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 z-10 text-white p-4 text-center backdrop-blur-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span class="font-bold">Click to upload new image</span>
                                        <span class="text-xs mt-1">(JPG, PNG. Max 2MB)</span>
                                        <span class="text-xs text-gray-300 mt-2">Leave empty to keep current image.</span>
                                    </div>

                                    <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*"
                                           @change="bannerPreview = URL.createObjectURL($event.target.files[0])" />
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic border-l-4 border-purple-200 pl-3 py-1">
                            Note: You are editing a written piece. Image upload is disabled to maintain its format.
                        </p>
                    @endif


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Title</label>
                            <input type="text" name="title" value="{{ old('title', $artwork->title) }}" required class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 font-medium placeholder-gray-400">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category</label>
                            <select name="category_id" required class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 cursor-pointer">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $artwork->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>
                    </div>


                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                            {{ $artwork->image ? 'Description' : 'Your Story / Poem Content' }}
                        </label>
                        
                        <textarea name="description" rows="{{ $artwork->image ? '6' : '12' }}"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 leading-relaxed placeholder-gray-400 font-serif"
                            placeholder="Write something here..." required>{{ old('description', $artwork->description) }}</textarea>
                        
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        @if(!$artwork->image)
                            <p class="text-xs text-gray-500 mt-2">Tip: Use line breaks to format your poetry or paragraphs nicely.</p>
                        @endif
                    </div>


                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tags</label>
                        <input type="text" name="tags" value="{{ old('tags', $tagsString ?? '') }}" class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400" placeholder="e.g. abstract, nature, poetry (comma separated)">
                        <p class="text-xs text-gray-500 mt-2">Separate tags with commas.</p>
                    </div>


                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('member.artworks.index') }}" class="text-gray-500 font-bold hover:text-black px-4 py-2 transition">Cancel</a>
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Update Artwork
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>