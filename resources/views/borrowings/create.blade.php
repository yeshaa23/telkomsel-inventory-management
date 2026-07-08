<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="gsm-eyebrow">{{ __('app.borrowing') }}</p>
            <h2>{{ __('app.add_borrowing') }}</h2>
        </div>
    </x-slot>

    <div class="gsm-dashboard">
        <section class="gsm-panel">
            <div class="gsm-panel-header">
                <div>
                    <p class="gsm-eyebrow">{{ __('app.new_borrowing') }}</p>
                    <h3>{{ __('app.add_borrowing_form') }}</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ __('app.borrowing_form_desc') }}
                    </p>
                </div>

                <a href="{{ route('borrowings.index') }}" class="gsm-button-secondary">
                    {{ __('app.back') }}
                </a>
            </div>

            <form action="{{ route('borrowings.store') }}" method="POST" class="gsm-form-layout">
                @csrf

                <div class="gsm-form-main">
                    <div class="gsm-form-grid">
                        <div class="gsm-field">
                            <label for="borrower_name">{{ __('app.borrower_name') }}</label>

                            <input
                                type="text"
                                name="borrower_name"
                                id="borrower_name"
                                required
                                value="{{ old('borrower_name') }}"
                                placeholder="Contoh: Ayesha Hana"
                            >

                            @error('borrower_name')
                                <p class="gsm-error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="gsm-field">
                            <label for="division">{{ __('app.division') }}</label>

                            <select name="division" id="division">
                                <option value="">{{ __('app.choose_division') }}</option>
                                <option value="IT" {{ old('division') == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="Finance" {{ old('division') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Human Resources" {{ old('division') == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                                <option value="Marketing" {{ old('division') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Sales" {{ old('division') == 'Sales' ? 'selected' : '' }}>Sales</option>
                                <option value="Operations" {{ old('division') == 'Operations' ? 'selected' : '' }}>Operations</option>
                                <option value="Customer Service" {{ old('division') == 'Customer Service' ? 'selected' : '' }}>Customer Service</option>
                                <option value="General Affairs" {{ old('division') == 'General Affairs' ? 'selected' : '' }}>General Affairs</option>
                                <option value="Other" {{ old('division') == 'Other' ? 'selected' : '' }}>{{ __('app.other') }}</option>
                            </select>

                            @error('division')
                                <p class="gsm-error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="gsm-field">
                            <label for="borrow_date">{{ __('app.borrow_date') }}</label>

                            <input
                                type="date"
                                name="borrow_date"
                                id="borrow_date"
                                required
                                value="{{ old('borrow_date', date('Y-m-d')) }}"
                            >

                            @error('borrow_date')
                                <p class="gsm-error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="gsm-field">
                            <label for="due_date">{{ __('app.due_date') }}</label>

                            <input
                                type="date"
                                name="due_date"
                                id="due_date"
                                value="{{ old('due_date') }}"
                            >

                            <small>{{ __('app.due_date_help') }}</small>

                            @error('due_date')
                                <p class="gsm-error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="gsm-field gsm-field-full">
                            <label for="product_search">{{ __('app.product') }}</label>

                            @php
                                $productOptions = $products
                                    ->map(function ($product) {
                                        return [
                                            'id' => (string) $product->id,
                                            'code' => $product->code,
                                            'name' => $product->name,
                                            'stock' => (int) $product->good_stock,
                                            'label' => $product->code . ' - ' . $product->name . ' | ' . __('app.available_good_stock') . ': ' . $product->good_stock,
                                        ];
                                    })
                                    ->values();

                                $selectedProduct = $products->firstWhere('id', (int) old('product_id'));

                                $selectedProductLabel = $selectedProduct
                                    ? $selectedProduct->code . ' - ' . $selectedProduct->name . ' | ' . __('app.available_good_stock') . ': ' . $selectedProduct->good_stock
                                    : '';
                            @endphp

                            <input
                                type="text"
                                name="product_search"
                                id="product_search"
                                list="product_options"
                                value="{{ old('product_search', $selectedProductLabel) }}"
                                placeholder="{{ __('app.choose_product') }}"
                                autocomplete="off"
                                required
                            >

                            <input
                                type="hidden"
                                name="product_id"
                                id="product_id"
                                value="{{ old('product_id') }}"
                            >

                            <datalist id="product_options">
                                @foreach($productOptions as $option)
                                    <option value="{{ $option['label'] }}"></option>
                                @endforeach
                            </datalist>

                            <small>
                                {{ app()->getLocale() === 'id'
                                    ? 'Ketik kode atau nama barang, lalu pilih dari daftar yang muncul.'
                                    : 'Type the item code or name, then choose from the list.' }}
                            </small>

                            @error('product_id')
                                <p class="gsm-error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="gsm-field">
                            <label for="quantity">{{ __('app.quantity') }}</label>

                            <input
                                type="number"
                                name="quantity"
                                id="quantity"
                                required
                                value="{{ old('quantity', 1) }}"
                                min="1"
                                placeholder="1"
                            >

                            @error('quantity')
                                <p class="gsm-error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="gsm-form-actions">
                        <button class="gsm-button-primary">
                            {{ __('app.save_borrowing') }}
                        </button>

                        <a href="{{ route('borrowings.index') }}" class="gsm-button-secondary">
                            {{ __('app.cancel') }}
                        </a>
                    </div>
                </div>

                <aside class="gsm-helper-card">
                    <div class="gsm-helper-icon">↔</div>

                    <h4>{{ __('app.preview_borrowing') }}</h4>

                    <div class="gsm-preview-box">
                        <p>{{ __('app.selected_product') }}</p>
                        <strong id="preview-product">{{ __('app.not_selected_yet') }}</strong>
                    </div>

                    <ul>
                        <li>{{ __('app.borrowing_tip_1') }}</li>
                        <li>{{ __('app.borrowing_tip_2') }}</li>
                        <li>{{ __('app.borrowing_tip_3') }}</li>
                    </ul>
                </aside>
            </form>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSearch = document.getElementById('product_search');
            const productInput = document.getElementById('product_id');
            const previewProduct = document.getElementById('preview-product');
            const borrowingForm = document.querySelector('form[action="{{ route('borrowings.store') }}"]');

            const productOptions = @json($productOptions);
            const stockText = @json(__('app.available_good_stock'));
            const notSelectedText = @json(__('app.not_selected_yet'));
            const invalidProductText = @json(app()->getLocale() === 'id'
                ? 'Pilih barang dari daftar yang tersedia.'
                : 'Choose a product from the available list.');

            function findProductByLabel(label) {
                return productOptions.find(function (product) {
                    return product.label === label;
                });
            }

            function findProductById(id) {
                return productOptions.find(function (product) {
                    return product.id === String(id);
                });
            }

            function updateProductPreview(product) {
                if (!previewProduct) {
                    return;
                }

                if (!product) {
                    previewProduct.textContent = notSelectedText;
                    return;
                }

                previewProduct.textContent = `${product.code} | ${stockText}: ${product.stock}`;
            }

            function syncProductSelection() {
                if (!productSearch || !productInput) {
                    return;
                }

                productSearch.setCustomValidity('');

                const selectedProduct = findProductByLabel(productSearch.value.trim());

                if (!selectedProduct) {
                    productInput.value = '';
                    updateProductPreview(null);
                    return;
                }

                productInput.value = selectedProduct.id;
                updateProductPreview(selectedProduct);
            }

            if (productSearch && productInput) {
                const selectedProduct = findProductById(productInput.value);

                if (selectedProduct && !productSearch.value) {
                    productSearch.value = selectedProduct.label;
                }

                updateProductPreview(selectedProduct || findProductByLabel(productSearch.value.trim()));

                productSearch.addEventListener('input', syncProductSelection);
                productSearch.addEventListener('change', syncProductSelection);

                if (borrowingForm) {
                    borrowingForm.addEventListener('submit', function (event) {
                        syncProductSelection();

                        if (!productInput.value) {
                            event.preventDefault();
                            productSearch.setCustomValidity(invalidProductText);
                            productSearch.reportValidity();
                        }
                    });
                }
            }
        });
    </script>
</x-app-layout>
