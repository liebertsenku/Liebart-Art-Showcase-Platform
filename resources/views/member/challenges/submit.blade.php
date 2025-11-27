<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Submit ke Challenge: {{ $challenge->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <p class="text-gray-600">Silakan pilih salah satu karya Anda untuk diikutsertakan dalam challenge ini.</p>
                    <p class="text-sm text-red-500 mt-1">* Deadline: {{ \Carbon\Carbon::parse($challenge->deadline)->format('d M Y H:i') }}</p>
                </div>

                <form action="{{ route('challenges.submit.store', $challenge->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Pilih Artwork</label>
                        @if($myArtworks->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($myArtworks as $art)
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="artwork_id" value="{{ $art->id }}" class="peer sr-only" required>
                                    <div class="border-2 border-gray-200 rounded-lg p-2 hover:border-blue-300 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                        <img src="{{ asset('storage/'.$art->image_path) }}" class="w-full h-32 object-cover rounded-md mb-2">
                                        <div class="font-bold text-sm truncate">{{ $art->title }}</div>
                                    </div>
                                    <div class="absolute top-4 right-4 text-blue-600 opacity-0 peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-500 mb-2">Anda belum memiliki artwork.</p>
                                <a href="{{ route('member.artworks.create') }}" class="text-blue-600 underline">Upload Artwork Baru</a>
                            </div>
                        @endif
                        @error('artwork_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition" 
                            {{ $myArtworks->isEmpty() ? 'disabled' : '' }}>
                            Submit Karya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>