<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
                <a href="{{ route('admin.categories.create') }}" class="bg-black text-white px-4 py-2 rounded-lg font-bold hover:bg-gray-800">+ Add Category</a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Artworks Count</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($categories as $category)
                        <tr>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $category->artworks_count }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete category?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>