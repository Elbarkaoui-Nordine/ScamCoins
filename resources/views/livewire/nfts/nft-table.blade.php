<div>
    @if($nfts->isEmpty())
        <div class="text-center py-4 text-gray-400">
            No data available
        </div>
    @else
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-slate-900">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-200 sm:pl-6">#</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200 min-w-40">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">Symbol</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">Platform</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">Contract Address</th>
                                </tr>
                            </thead>
                            <tbody wire:loading.remove class="divide-y divide-gray-700 bg-slate-900">
                                @forelse($nfts as $index => $nft)
                                    <tr class="hover:bg-slate-800 cursor-pointer" @click="window.location.href = '{{ route('nft.show', $nft['id']) }}'">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-200 sm:pl-6">
                                            {{ ($page - 1) * $perPage + (int)$index + 1 }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            <div class="flex items-center">
                                                <span class="ml-2 font-medium text-white">🃏 {{ $nft['name'] ?? 'Unnamed NFT' }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $nft['symbol'] ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $nft['asset_platform_id'] ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            @if(isset($nft['contract_address']) && $nft['contract_address'])
                                                <span class="truncate max-w-[200px] inline-block">{{ $nft['contract_address'] }}</span>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-4 text-sm text-gray-300 text-center">No NFTs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-sm text-gray-300 text-center">
                                    <div wire:loading class="flex justify-center items-center py-8">
                                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $nfts->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    @endif
</div> 