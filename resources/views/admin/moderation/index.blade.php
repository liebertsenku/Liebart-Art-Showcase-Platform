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
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reported Artwork</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reason</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reporter</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reports as $report)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-12 w-16 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                            @if($report->artwork)
                                                <img class="h-full w-full object-cover" src="{{ asset('storage/'.$report->artwork->image) }}" alt="">
                                            @else
                                                <div class="flex items-center justify-center h-full text-xs text-gray-400">Del</div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $report->artwork->title ?? 'Artwork Deleted' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                by {{ $report->artwork->user->name ?? 'Unknown' }}
                                            </div>
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
                                            <button type="submit" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 text-xs font-bold">
                                                Reject
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.moderation.approve', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the artwork.')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs font-bold">
                                                Approve & Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    No pending reports. Great job!
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