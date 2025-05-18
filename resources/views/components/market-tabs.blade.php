<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="{{ route('home') }}" 
               class="{{ request()->routeIs('home') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                <span class="mr-2">🪙</span>
                Coins
            </a>
            <a href="{{ route('nfts') }}" 
               class="{{ request()->routeIs('nfts') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                <span class="mr-2">🃏</span>
                NFTs
            </a>
        </nav>
    </div>
</div> 