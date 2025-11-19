<x-guest-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}" class="w-full h-auto object-cover">
                
                <div class="p-6 md:p-10 text-gray-900">
                    <h1 class="text-3xl font-bold mb-2">{{ $artwork->title }}</h1>
                    
                    <div class="flex items-center text-gray-600 mb-4">
                        <span class="font-medium">Oleh: {{ $artwork->user->name }}</span>
                        <span class="mx-2">|</span>
                        <span>Kategori: {{ $artwork->category->name }}</span>
                    </div>
                    
                    <div class="prose max-w-none">
                        {!! nl2br(e($artwork->description)) !!}
                    </div>

                    @if ($artwork->tags)
                    <div class="mt-6">
                        <span class="font-medium">Tags:</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($artwork->tags as $tag)
                                <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-sm">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>