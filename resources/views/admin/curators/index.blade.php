<x-app-layout>
    <div class="py-12 bg-[#F5F4F2] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Curator Applications</h1>
                    <p class="text-gray-500 mt-1">Review and manage curator requests.</p>
                </div>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Applicant</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Organization</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reason</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($curators as $curator)
                            <tr class="hover:bg-gray-50 transition">
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-black text-white flex items-center justify-center font-bold text-sm">
                                            {{ substr($curator->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $curator->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $curator->user->email }}</div>
                                            @if($curator->portfolio_link)
                                                <a href="{{ $curator->portfolio_link }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 block">
                                                    View Portfolio &rarr;
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $curator->organization_name }}</div>
                                    @if($curator->organization_website)
                                        <a href="{{ $curator->organization_website }}" target="_blank" class="text-xs text-gray-500 hover:text-black">
                                            {{ parse_url($curator->organization_website, PHP_URL_HOST) }}
                                        </a>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $curator->reason_for_applying }}">
                                        {{ Str::limit($curator->reason_for_applying, 50) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $class = $statusClasses[$curator->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $class }}">
                                        {{ ucfirst($curator->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    
                                    @if($curator->status === 'pending')
                                        <div class="flex justify-end items-center gap-2">
                                            
                                            <form action="{{ route('admin.curators.reject', $curator->id) }}" method="POST" onsubmit="return confirm('Reject this application?')">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-red-600 text-xs font-bold transition shadow-sm">
                                                    Reject
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.curators.approve', $curator->id) }}" method="POST" onsubmit="return confirm('Approve this user as Curator?')">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-black text-white rounded-lg hover:bg-gray-800 text-xs font-bold transition shadow-md flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                                    Approve
                                                </button>
                                            </form>

                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Processed {{ $curator->updated_at->diffForHumans() }}</span>
                                    @endif

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="font-medium text-gray-900">No applications yet</p>
                                        <p class="text-sm text-gray-400">Wait for members to apply as curators.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $curators->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>