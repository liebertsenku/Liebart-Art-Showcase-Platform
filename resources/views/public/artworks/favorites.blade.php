<x-app-layout>
    <div class="min-h-screen bg-[#F5F4F2] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 flex items-end gap-4">
                <div class="p-3 bg-yellow-100 rounded-2xl text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Your Favorites</h1>
                    <p class="text-gray-500 mt-1">Collection of artworks and stories you love.</p>
                </div>
            </div>

            @if($artworks->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($artworks as $artwork)
                        <div class="bg-white rounded-[20px] overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 group relative flex flex-col h-full">
                            
                            <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden group/media">
                                <a href="{{ route('artworks.show', $artwork) }}" class="block w-full h-full">
                                    @if($artwork->image)
                                        <img src="{{ asset('storage/' . $artwork->image) }}" class="w-full h-full object-cover transform group-hover/media:scale-105 transition duration-700">
                                    @else
                                        <div class="w-full h-full p-6 flex flex-col justify-center items-center text-center bg-white border-b border-gray-50 group-hover/media:bg-gray-50 transition">
                                            <span class="text-4xl text-gray-200 mb-2 font-serif">❝</span>
                                            <p class="text-gray-800 font-serif text-sm leading-relaxed line-clamp-4 italic">
                                                {{ $artwork->description }}
                                            </p>
                                            <span class="mt-auto text-[10px] uppercase tracking-widest text-gray-400 font-bold pt-4">Written Piece</span>
                                        </div>
                                    @endif
                                </a>
                            </div>

                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="font-bold text-gray-900 truncate mb-1">
                                    <a href="{{ route('artworks.show', $artwork) }}">{{ $artwork->title }}</a>
                                </h3>
                                
                                <div class="mt-auto pt-3 border-t border-gray-50 flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                                        @if($artwork->user->profile_photo_path)
                                            <img src="{{ asset('storage/'.$artwork->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-black flex items-center justify-center text-[8px] text-white font-bold">{{ substr($artwork->user->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500 truncate">{{ $artwork->user->name }}</span>
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