<div x-data="{
    search: @entangle('search'),
    results: @entangle('results'),
    loading: @entangle('loading'),
    showResults: false,
    init() {
        this.$watch('search', (value) => {
            this.debounceSearch();
            this.showResults = value.length > 0;
        });
    },
    debounceSearch() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            $wire.performSearch();
        }, 300);
    }
}">
    <form class="max-w-md mx-auto">   
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg x-show="!loading" class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <svg x-show="loading" class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <input 
                x-model="search"
                @click="showResults = true"
                id="crypto-search" 
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Search cryptocurrencies..."  
            />
            <div x-show="search && !loading && results.length === 0 && showResults" 
                 @click.away="showResults = false"
                 class="py-2 mx-auto absolute bg-white rounded-lg shadow divide-gray-200 w-70 text-center text-gray-500">
                No cryptocurrencies found
            </div>
        </div>
    </form>

    <!-- Results -->
    <div x-show="showResults && results.length > 0" 
         @click.away="showResults = false"
         class="max-w-md mx-auto absolute w-full">
        <div class="bg-white shadow">
            <ul class="divide-y divide-gray-200 max-h-60 overflow-y-auto">
                <template x-for="crypto in results" :key="crypto.id">
                    <li class="px-2 hover:bg-gray-50">
                        <a :href="'/crypto/'+crypto.id">
                            <div class="flex items-center space-x-4">
                                <img :src="crypto.thumb" class="w-8 h-8" :alt="crypto.name">
                                <div>
                                    <p class="text-sm font-medium text-gray-900" x-text="crypto.name"></p>
                                    <p class="text-sm text-gray-500" x-text="crypto.symbol.toUpperCase()"></p>
                                </div>
                                <div class="ml-auto">
                                    <p class="text-xs text-gray-500">Rank #<span x-text="crypto.market_cap_rank"></span></p>
                                </div>
                            </div>
                        </a>        
                    </li>
                </template>
            </ul>
        </div>
    </div>
</div>
