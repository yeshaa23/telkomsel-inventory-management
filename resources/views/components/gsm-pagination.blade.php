@props([
    'paginator',
])

@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $from = $paginator->firstItem() ?? 0;
        $to = $paginator->lastItem() ?? 0;
        $total = $paginator->total();
        $isEnglish = app()->getLocale() === 'en';
    @endphp

    <nav class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-semibold text-slate-500">
            @if($isEnglish)
                Showing {{ $from }} - {{ $to }} of {{ $total }} data
            @else
                Menampilkan {{ $from }} - {{ $to }} dari {{ $total }} data
            @endif
        </p>

        <div class="flex flex-wrap items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="gsm-button-secondary opacity-50 cursor-not-allowed">
                    {{ $isEnglish ? 'Previous' : 'Sebelumnya' }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="gsm-button-secondary">
                    {{ $isEnglish ? 'Previous' : 'Sebelumnya' }}
                </a>
            @endif

            @for ($page = 1; $page <= $lastPage; $page++)
                @if ($lastPage <= 7 || $page === 1 || $page === $lastPage || abs($page - $currentPage) <= 1)
                    @if ($page === $currentPage)
                        <span class="gsm-button-primary">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="gsm-button-secondary">
                            {{ $page }}
                        </a>
                    @endif
                @elseif ($page === 2 && $currentPage > 4)
                    <span class="px-2 text-sm font-bold text-slate-400">...</span>
                @elseif ($page === $lastPage - 1 && $currentPage < $lastPage - 3)
                    <span class="px-2 text-sm font-bold text-slate-400">...</span>
                @endif
            @endfor

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="gsm-button-secondary">
                    {{ $isEnglish ? 'Next' : 'Berikutnya' }}
                </a>
            @else
                <span class="gsm-button-secondary opacity-50 cursor-not-allowed">
                    {{ $isEnglish ? 'Next' : 'Berikutnya' }}
                </span>
            @endif
        </div>
    </nav>
@endif
