<header class="bg-slate-900 border-b border-gray-700 shadow">
    <nav class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('/main-icon.png') }}" alt="ScamCoins" class="h-8 w-8">
                <a href="{{ route('home') }}" class="text-xl font-bold text-white">
                    ScamCoins
                </a>
            </div>
            <div class="flex items-center">
               <livewire:crypto-search />
            </div>
        </div>
    </nav>
</header> 