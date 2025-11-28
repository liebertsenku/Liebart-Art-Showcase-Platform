<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex items-center gap-4">
                <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-500 hover:text-black shadow-sm transition">
                    &larr;
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">New Category</h1>
                    <p class="text-gray-500 text-sm">Create a new classification for artworks.</p>
                </div>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm p-8 border border-gray-100">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 font-medium"
                            placeholder="e.g. 3D Modeling, Watercolor">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full bg-[#F5F4F2] border-transparent focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 leading-relaxed"
                            placeholder="Short description about this category...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-black transition">Cancel</a>
                        <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>