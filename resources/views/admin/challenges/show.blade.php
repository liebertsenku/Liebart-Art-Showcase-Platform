<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('admin.challenges.index') }}" class="text-gray-500 hover:text-black">&larr; Back to Challenges</a>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm mb-8 flex flex-col md:flex-row gap-8">
                @if($challenge->cover_image)
                    <img src="{{ asset('storage/'.$challenge->cover_image) }}" class="w-full md:w-1/3 rounded-xl object-cover h-64">
                @endif
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $challenge->title }}</h1>
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-bold uppercase">{{ $challenge->status }}</span>
                    </div>
                    <p class="text-gray-500 mt-2">{{ $challenge->start_date->format('d M Y') }} - {{ $challenge->end_date->format('d M Y') }}</p>
                    <p class="mt-4 text-gray-700 leading-relaxed">{{ $challenge->description }}</p>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-6">Submissions ({{ $submissions->count() }})</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($submissions as $submission)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm group">
                        <div class="relative h-48">
                            <img src="{{ asset('storage/'.$submission->artwork->image) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <form action="{{ route('admin.challenges.submission.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Remove this submission?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700">Remove Submission</button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="font-bold text-gray-900 truncate">{{ $submission->artwork->title }}</div>
                            <div class="text-xs text-gray-500">by {{ $submission->artwork->user->name }}</div>
                            <div class="mt-2 text-sm font-bold text-black flex items-center gap-1">
                                <span>❤️</span> {{ $submission->artwork->likes_count }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>