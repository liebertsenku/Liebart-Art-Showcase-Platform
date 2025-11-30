<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Challenge Manager</h1>
                <p class="text-gray-500 mt-2">Manage events and remove inappropriate submissions.</p>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Challenge Info</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Submissions</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($challenges as $challenge)
                            <tr class="hover:bg-gray-50 transition">
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
                                            <div class="text-sm font-bold text-gray-900">{{ $challenge->title }}</div>
                                            <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($challenge->description, 50) }}</div>
                                            <div class="text-[10px] text-blue-600 mt-1">by {{ $challenge->curator->name ?? 'Admin' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $now = now();
                                        if ($now < $challenge->start_date) {
                                            $statusText = 'Upcoming'; $statusClass = 'bg-yellow-100 text-yellow-800';
                                        } elseif ($now > $challenge->end_date) {
                                            $statusText = 'Ended'; $statusClass = 'bg-gray-100 text-gray-500';
                                        } else {
                                            $statusText = 'Ongoing'; $statusClass = 'bg-green-100 text-green-800 animate-pulse';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-lg font-bold text-gray-900">{{ $challenge->submissions_count }}</span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('admin.challenges.show', $challenge->id) }}" class="text-gray-600 hover:text-black hover:underline mr-3">View</a>
                                    
                                    <form action="{{ route('admin.challenges.destroy', $challenge->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure? This will delete all submissions too.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    No challenges found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $challenges->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>