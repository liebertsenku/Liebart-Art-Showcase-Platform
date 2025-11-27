<x-app-layout>
    <div class="mt-6 border-t border-gray-100 pt-6">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                
                <form action="{{ route('artworks.like', $artwork->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-1 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 transition {{ Auth::user()->hasLiked($artwork) ? 'text-red-500 fill-current' : 'text-gray-400 group-hover:text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-600">{{ $artwork->likes()->count() }}</span>
                    </button>
                </form>

                <form action="{{ route('artworks.favorite', $artwork->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-1 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 transition {{ Auth::user()->hasFavorited($artwork) ? 'text-yellow-500 fill-current' : 'text-gray-400 group-hover:text-yellow-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </button>
                </form>
            </div>

            @if($artwork->user_id !== Auth::id())
            <div x-data="{ open: false }">
                <button @click="open = true" class="text-gray-400 hover:text-red-600 text-sm font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h10a2 2 0 012 2v6a2 2 0 01-2 2H2.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-8a2 2 0 01-2-2h-5m-5 4h5" />
                    </svg>
                    Report
                </button>

                <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md">
                        <h3 class="text-lg font-bold mb-4">Laporkan Karya Ini</h3>
                        <form action="{{ route('artworks.report', $artwork->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Pelaporan</label>
                                <select name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Plagiarisme">Plagiarisme / Hak Cipta</option>
                                    <option value="SARA">Konten SARA / Kebencian</option>
                                    <option value="Nudity">Konten Seksual / Nudity</option>
                                    <option value="Spam">Spam / Penipuan</option>
                                </select>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Kirim Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-gray-50 rounded-xl p-6">
            <h3 class="font-bold text-lg mb-4">Komentar ({{ $artwork->comments->count() }})</h3>
            
            <form action="{{ route('artworks.comment.store', $artwork->id) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="body" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black" placeholder="Tulis komentar Anda..."></textarea>
                <button type="submit" class="mt-2 bg-black text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-800">Kirim</button>
            </form>

            <div class="space-y-4">
                @foreach($artwork->comments as $comment)
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center font-bold text-xs">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start">
                                <span class="font-bold text-sm">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 mt-1">{{ $comment->body }}</p>
                        </div>
                        
                        @if($comment->user_id === Auth::id())
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-1">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
<x-app-layout>