<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="gsm-eyebrow">{{ __('app.global_search') }}</p>
            <h2>{{ __('app.search_results') }}</h2>
        </div>
    </x-slot>

    <div class="gsm-dashboard">
        <section class="gsm-panel">
            <div class="gsm-panel-header">
                <div>
                    <p class="gsm-eyebrow">{{ __('app.search') }}</p>
                    <h3>
                        {{ __('app.search_results_for') }}
                        <span class="text-red-600">"{{ $query }}"</span>
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ __('app.search_results_desc', ['count' => $totalResults]) }}
                    </p>
                </div>
            </div>

            <form method="GET" action="{{ route('search.index') }}" class="gsm-filter-card">
                <div>
                    <label>{{ __('app.keyword') }}</label>

                    <input
                        type="text"
                        name="q"
                        value="{{ $query }}"
                        placeholder="{{ __('app.global_search_placeholder') }}"
                        autofocus
                    >
                </div>

                <div class="gsm-filter-actions">
                    <button class="gsm-button-primary">
                        {{ __('app.search') }}
                    </button>

                    <a href="{{ route('dashboard') }}" class="gsm-button-secondary">
                        {{ __('app.back') }}
                    </a>
                </div>
            </form>
        </section>

        @if($query === '')
            <section class="gsm-panel">
                <div class="gsm-empty-state">
                    {{ __('app.search_empty_keyword') }}
                </div>
            </section>
        @elseif($totalResults === 0)
            <section class="gsm-panel">
                <div class="gsm-empty-state">
                    {{ __('app.no_search_results') }}
                </div>
            </section>
        @else
            @if($products->count() > 0)
                <section class="gsm-panel">
                    <div class="gsm-panel-header">
                        <div>
                            <p class="gsm-eyebrow">{{ __('app.products') }}</p>
                            <h3>{{ __('app.product_results') }}</h3>
                        </div>

                        <a href="{{ route('products.index', ['search' => $query]) }}" class="gsm-button-secondary">
                            {{ __('app.view_all') }}
                        </a>
                    </div>

                    <div class="gsm-table-wrapper">
                        <table class="gsm-table">
                            <thead>
                                <tr>
                                    <th>{{ __('app.product_code') }}</th>
                                    <th>{{ __('app.product_name') }}</th>
                                    <th>{{ __('app.category') }}</th>
                                    <th>{{ __('app.stock') }}</th>
                                    <th>{{ __('app.location') }}</th>
                                    <th>{{ __('app.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->location }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" class="gsm-action-link view">
                                                {{ __('app.detail') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif

            @if($borrowings->count() > 0)
                <section class="gsm-panel">
                    <div class="gsm-panel-header">
                        <div>
                            <p class="gsm-eyebrow">{{ __('app.borrowings') }}</p>
                            <h3>{{ __('app.borrowing_results') }}</h3>
                        </div>

                        <a href="{{ route('borrowings.index', ['search' => $query]) }}" class="gsm-button-secondary">
                            {{ __('app.view_all') }}
                        </a>
                    </div>

                    <div class="gsm-table-wrapper">
                        <table class="gsm-table">
                            <thead>
                                <tr>
                                    <th>{{ __('app.borrower_name') }}</th>
                                    <th>{{ __('app.division') }}</th>
                                    <th>{{ __('app.borrow_date') }}</th>
                                    <th>{{ __('app.status') }}</th>
                                    <th>{{ __('app.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->borrower_name }}</td>
                                        <td>{{ $borrowing->division ?? '-' }}</td>
                                        <td>{{ $borrowing->borrow_date?->format('d M Y') }}</td>
                                        <td>
                                            <span class="gsm-badge {{ $borrowing->display_status === 'returned' ? 'success' : ($borrowing->display_status === 'overdue' ? 'danger' : 'warning') }}">
                                                {{ $borrowing->display_status_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('borrowings.show', $borrowing) }}" class="gsm-action-link view">
                                                {{ __('app.detail') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif

            @if($categories->count() > 0)
                <section class="gsm-panel">
                    <div class="gsm-panel-header">
                        <div>
                            <p class="gsm-eyebrow">{{ __('app.categories') }}</p>
                            <h3>{{ __('app.category_results') }}</h3>
                        </div>
                    </div>

                    <div class="gsm-table-wrapper">
                        <table class="gsm-table">
                            <thead>
                                <tr>
                                    <th>{{ __('app.category_name') }}</th>
                                    <th>{{ __('app.description') }}</th>
                                    <th>{{ __('app.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category) }}" class="gsm-action-link edit">
                                                {{ __('app.edit') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif

            @if($activityLogs->count() > 0)
                <section class="gsm-panel">
                    <div class="gsm-panel-header">
                        <div>
                            <p class="gsm-eyebrow">{{ __('app.activity_logs') }}</p>
                            <h3>{{ __('app.activity_log_results') }}</h3>
                        </div>

                        <a href="{{ route('activity-logs.index') }}" class="gsm-button-secondary">
                            {{ __('app.view_all') }}
                        </a>
                    </div>

                    <div class="gsm-table-wrapper">
                        <table class="gsm-table">
                            <thead>
                                <tr>
                                    <th>{{ __('app.user') }}</th>
                                    <th>{{ __('app.module') }}</th>
                                    <th>{{ __('app.activity') }}</th>
                                    <th>{{ __('app.date') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($activityLogs as $log)
                                    <tr>
                                        <td>{{ $log->user->name ?? '-' }}</td>
                                        <td>{{ $log->module }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->created_at?->format('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        @endif
    </div>
</x-app-layout>
