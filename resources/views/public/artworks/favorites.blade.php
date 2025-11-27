<x-app-layout>
    <div class="min-h-screen bg-[#F5F4F2] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 flex items-end gap-4">
                <div class="p-3 bg-yellow-100 rounded-2xl text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Your Favorites</h1>
                    <p class="text-gray-500 mt-1">Collection of artworks you love.</p>
                </div>
            </div>

            @if($artworks->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($artworks as $artwork)
                        <div class="bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 group relative">
                            <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
                                <a href="{{ route('artworks.show', $artwork) }}">
                                    <img src="{{ asset('storage/' . $artwork->image) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                </a>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 truncate">
                                    <a href="{{ route('artworks.show', $artwork) }}">{{ $artwork->title }}</a>
                                </h3>
                                <div class="flex items-center gap-2 mt-2">
                                    <div class="w-5 h-5 rounded-full bg-gray-200 overflow-hidden">
                                        @if($artwork->user->profile_photo_path)
                                            <img src="{{ asset('storage/'.$artwork->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-black flex items-center justify-center text-[8px] text-white font-bold">{{ substr($artwork->user->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $artwork->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $artworks->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">No favorites yet</h3>
                    <p class="text-gray-500 mt-2">Start exploring and save artworks you love!</p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 bg-black text-white px-6 py-2 rounded-xl font-bold hover:bg-gray-800 transition">Explore Artworks</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>