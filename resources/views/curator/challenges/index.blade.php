<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- HEADER SECTION -->
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">My Challenges</h1>
                    <p class="text-gray-500 mt-1">Manage your events and submissions.</p>
                </div>
                
                <!-- TOMBOL CREATE CHALLENGE -->
                <a href="{{ route('curator.challenges.create') }}" class="bg-black text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create Challenge
                </a>
            </div>

            <!-- TABLE CARD -->
            <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Challenge Details</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Entries</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($challenges as $challenge)
                            <tr class="hover:bg-gray-50 transition group">
                                
                                <!-- Kolom 1: Detail (Gambar + Judul) -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-12 w-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                                            @if($challenge->banner_image)
                                                <img src="{{ asset('storage/'.$challenge->banner_image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $challenge->title }}</div>
                                            <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($challenge->description, 40) }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kolom 2: Tanggal -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">Duration: {{ $challenge->start_date->diffInDays($challenge->end_date) }} days</div>
                                </td>

                                <!-- Kolom 3: Status Badge -->
                                <td class="px-6 py-4">
                                    @php
                                        $status = $challenge->computed_status;
                                        $badgeClass = match($status) {
                                            'active' => 'bg-green-100 text-green-800',
                                            'upcoming' => 'bg-yellow-100 text-yellow-800',
                                            'ended' => 'bg-gray-100 text-gray-600',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-wide {{ $badgeClass }}">
                                        {{ $status }}
                                    </span>
                                </td>

                                <!-- Kolom 4: Submissions -->
                                <td class="px-6 py-4 text-center">
                                    <span class="text-lg font-bold text-gray-900">{{ $challenge->submissions_count }}</span>
                                    <span class="text-xs text-gray-500 block">Works</span>
                                </td>

                                <!-- Kolom 5: Actions -->
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('curator.challenges.show', $challenge->id) }}" class="text-gray-600 hover:text-black font-bold">Manage</a>
                                        
                                        <a href="{{ route('curator.challenges.edit', $challenge->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        
                                        <form action="{{ route('curator.challenges.destroy', $challenge->id) }}" method="POST" onsubmit="return confirm('Delete this challenge?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">No challenges found</h3>
                                        <p class="text-sm mt-1 mb-6">Start engaging the community by creating your first challenge.</p>
                                        <a href="{{ route('curator.challenges.create') }}" class="text-blue-600 font-bold hover:underline">Create Now &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $challenges->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>