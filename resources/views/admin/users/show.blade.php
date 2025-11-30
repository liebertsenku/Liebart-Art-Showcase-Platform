<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-black mb-6">
                &larr; Back to Users
            </a>

            <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-6">
                        <div class="h-24 w-24 rounded-full bg-black text-white flex items-center justify-center text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-500">{{ $user->email }}</p>
                            <div class="mt-2 flex gap-2">
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-bold uppercase tracking-wide">{{ $user->role }}</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold uppercase tracking-wide">Active</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->role !== 'admin')
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('EXTREME DANGER: Delete this user permanently?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition font-bold text-sm">
                            Delete User
                        </button>
                    </form>
                    @endif
                </div>

                <div class="grid grid-cols-3 gap-4 mt-8 pt-8 border-t border-gray-100">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-gray-900">{{ $user->artworks_count }}</span>
                        <span class="text-xs text-gray-500 uppercase">Artworks</span>
                    </div>
                    <div class="text-center border-l border-gray-100">
                        <span class="block text-2xl font-bold text-gray-900">{{ $user->likes_count }}</span>
                        <span class="text-xs text-gray-500 uppercase">Likes Given</span>
                    </div>
                    <div class="text-center border-l border-gray-100">
                        <span class="block text-2xl font-bold text-gray-900">{{ $user->comments_count }}</span>
                        <span class="text-xs text-gray-500 uppercase">Comments</span>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Artworks</h3>
            @if($recentArtworks->count() > 0)
                <div class="grid grid-cols-3 gap-4">
                    @foreach($recentArtworks as $art)
                        <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden relative group">
                            <img src="{{ asset('storage/'.$art->image) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white font-bold">
                                {{ $art->title }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">User has not uploaded any artwork yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>