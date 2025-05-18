@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        {{-- Mobile Pagination --}}
        <div class="flex flex-1 justify-between sm:hidden">
            <x-pagination.button
                class="bg-gray-700 text-white"
                :url="$paginator->previousPageUrl()"
                :disabled="$paginator->onFirstPage()"
                :label="__('pagination.previous')"
            >
                {!! __('pagination.previous') !!}
            </x-pagination.button>

            <x-pagination.button
                class="bg-gray-700 text-white"
                :url="$paginator->nextPageUrl()"
                :disabled="!$paginator->hasMorePages()"
                :label="__('pagination.next')"
                class="ml-3"
            >
                {!! __('pagination.next') !!}
            </x-pagination.button>
        </div>

        {{-- Desktop Pagination --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            {{-- Results Info --}}
            <div>
                <p class="text-sm text-white">
                    {!! __('Showing') !!}
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            {{-- Pagination Links --}}
            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page Link --}}
                    <x-pagination.button
                        class="bg-gray-700 text-white"
                        :url="$paginator->previousPageUrl()"
                        :disabled="$paginator->onFirstPage()"
                        :label="__('pagination.previous')"
                        :icon="'M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z'"
                        rounded="rounded-l-md"
                    />

                    {{-- Page Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="relative inline-flex cursor-default items-center border border-gray-600 bg-gray-700 px-4 py-2 text-sm font-medium text-white">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative inline-flex cursor-default items-center border border-gray-600 bg-gray-700 px-4 py-2 text-sm font-medium text-blue-400">
                                        {{ $page }}
                                    </span>
                                @else
                                    @if ($page == 1 || $page == $paginator->lastPage() || ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1))
                                        <x-pagination.button
                                            class="bg-gray-700 text-white"
                                            :url="$url"
                                            :label="__('Go to page :page', ['page' => $page])"
                                        >
                                            {{ $page }}
                                        </x-pagination.button>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    <x-pagination.button
                        class="bg-gray-700 text-white"
                        :url="$paginator->nextPageUrl()"
                        :disabled="!$paginator->hasMorePages()"
                        :label="__('pagination.next')"
                        :icon="'M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z'"
                        rounded="rounded-r-md"
                    />
                </span>
            </div>
        </div>
    </nav>
@endif 