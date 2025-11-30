<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Post New Work</h1>
                <p class="text-gray-500 mt-1">Share your art or writings.</p>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm p-8 border border-gray-100" x-data="{ type: 'image' }">
                
                <div class="flex gap-4 mb-8 border-b border-gray-100 pb-1">
                    <button @click="type = 'image'" 
                        :class="type === 'image' ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-gray-600'"
                        class="pb-3 text-sm font-bold uppercase tracking-wide transition">
                        🎨 Visual Art
                    </button>
                    <button @click="type = 'text'" 
                        :class="type === 'text' ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-gray-600'"
                        class="pb-3 text-sm font-bold uppercase tracking-wide transition">
                        📝 Story / Poem
                    </button>
                </div>

                <form action="{{ route('member.artworks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div x-show="type === 'image'" x-transition>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Artwork File</label>
                        <div class="relative w-full h-64 rounded-2xl bg-[#F5F4F2] border-2 border-dashed border-gray-300 hover:border-black transition flex flex-col items-center justify-center overflow-hidden cursor-pointer group">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                            <div class="text-center p-6">
                                <p class="text-gray-900 font-medium">Click to upload image</p>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max 2MB)</p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                            <span x-text="type === 'image' ? 'Description' : 'Your Story / Poem'"></span>
                        </label>
                        <textarea name="description" rows="8"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 leading-relaxed placeholder-gray-400"
                            placeholder="Write something here..."
                            :required="type === 'text'"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Title</label>
                            <input type="text" name="title" required class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category</label>
                            <select name="category_id" required class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tags</label>
                        <input type="text" name="tags" class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900" placeholder="Comma separated">
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg">
                            Publish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>