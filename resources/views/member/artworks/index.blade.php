<x-app-layout>
    <div class="min-h-screen bg-[#F5F4F2] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">
                        {{ __('My Artworks') }}
                    </h2>
                    <p class="text-gray-500 mt-2 text-sm">Manage your portfolio and showcase your creativity.</p>
                </div>

                <a href="{{ route('member.artworks.create') }}" 
                   class="inline-flex items-center justify-center bg-black text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    {{ __('Upload New') }}
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-800 rounded-xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-8 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Artwork</th>
                                <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Uploaded</th>
                                <th class="px-8 py-6 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($artworks as $artwork)
                                <tr class="hover:bg-[#FAFAFA] transition duration-150 group">
                                    
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-20 h-14 bg-gray-100 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0 flex items-center justify-center">
                                                @if($artwork->image)
                                                    <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="text-gray-400 bg-gray-50 w-full h-full flex flex-col items-center justify-center">
                                                        <span class="text-xl">📝</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="min-w-0">
                                                <div class="font-bold text-gray-900 text-lg leading-tight truncate max-w-xs">{{ $artwork->title }}</div>
                                                <div class="text-xs text-gray-400 mt-1">ID: #{{ $artwork->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#F5F4F2] text-gray-600">
                                            {{ $artwork->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5">
                                        @if($artwork->image)
                                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">Visual</span>
                                        @else
                                            <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded">Writing</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="text-sm text-gray-600 font-medium">
                                            {{ $artwork->created_at->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $artwork->created_at->format('H:i') }}
                                        </div>
                                    </td>

                                    <td class="px-8 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('artworks.show', $artwork) }}" target="_blank" class="p-2 text-gray-400 hover:text-black hover:bg-gray-100 rounded-lg transition" title="View Public Page">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('member.artworks.edit', $artwork) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('member.artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this artwork?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900">No artworks found</h3>
                                            <p class="text-gray-500 max-w-sm mt-1 mb-6">You haven't uploaded any masterpieces yet. Start sharing your creativity with the world.</p>
                                            <a href="{{ route('member.artworks.create') }}" class="text-black font-medium underline hover:text-gray-600 transition">
                                                Upload your first artwork
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($artworks->hasPages())
                    <div class="px-8 py-6 border-t border-gray-100 bg-gray-50">
                        {{ $artworks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>