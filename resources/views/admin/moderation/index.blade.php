<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Content Moderation</h1>
                <p class="text-gray-500">Review reports from members.</p>
            </div>

            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reported Content</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reason</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reporter</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reports as $report)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1 flex-shrink-0">
                                            @if($report->reportable_type === 'App\Models\Artwork')
                                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold uppercase tracking-wide">Artwork</span>
                                            @else
                                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-bold uppercase tracking-wide">Comment</span>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            @if($report->reportable)
                                                @if($report->reportable_type === 'App\Models\Artwork')
                                                    <div class="flex items-center gap-3">
                                                        <div class="h-12 w-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                                            @if($report->reportable->image)
                                                                <img class="h-full w-full object-cover" src="{{ asset('storage/'.$report->reportable->image) }}" alt="">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">Text</div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $report->reportable->title }}</div>
                                                            <div class="text-xs text-gray-500">by {{ $report->reportable->user->name ?? 'Unknown' }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="bg-gray-50 p-2 rounded border border-gray-100 text-sm italic text-gray-600 max-w-xs line-clamp-2">
                                                        "{{ Str::limit($report->reportable->body, 100) }}"
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        Comment by {{ $report->reportable->user->name ?? 'Unknown' }}
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-red-500 text-xs italic bg-red-50 px-2 py-1 rounded">Content already deleted</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                        {{ $report->reason }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">Submitted {{ $report->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $report->reporter->name }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('admin.moderation.reject', $report->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 text-xs font-bold transition">
                                                Reject
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.moderation.approve', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the content PERMANENTLY.')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs font-bold transition shadow-sm">
                                                Delete Content
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        No pending reports. Great job!
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>