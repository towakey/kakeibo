<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('取引登録') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transactions.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="transaction_date" :value="__('取引日')" />
                            <x-text-input id="transaction_date" name="transaction_date" type="date" class="mt-1 block w-full" required value="{{ date('Y-m-d') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('transaction_date')" />
                        </div>

                        <div>
                            <x-input-label :value="__('店舗')" />
                            <input type="hidden" name="store_id" id="store_id">
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($stores as $store)
                                    <button type="button"
                                            class="store-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            data-store-id="{{ $store->id }}"
                                            onclick="selectStore(this, {{ $store->id }})">
                                        {{ $store->name }}
                                    </button>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('store_id')" />
                        </div>

                        <div>
                            <x-input-label :value="__('商品')" />
                            <div class="mt-2 space-y-4">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($products as $product)
                                        <button type="button"
                                                class="product-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-default-price="{{ $product->default_price }}"
                                                onclick="toggleProduct(this)">
                                            {{ $product->name }}
                                            @if($product->default_price)
                                                <br><span class="text-sm text-gray-600">¥{{ number_format($product->default_price) }}</span>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                                <div id="selected-products" class="mt-4">
                                    <!-- Selected products will be displayed here -->
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('products')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('登録') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectStore(button, storeId) {
            document.querySelectorAll('.store-button').forEach(btn => {
                btn.classList.remove('bg-indigo-500', 'text-white');
            });
            
            button.classList.add('bg-indigo-500', 'text-white');
            document.getElementById('store_id').value = storeId;
        }

        function toggleProduct(button) {
            const productId = button.dataset.productId;
            const isSelected = button.classList.contains('bg-indigo-500');
            
            if (isSelected) {
                button.classList.remove('bg-indigo-500', 'text-white');
                document.querySelector(`#product-row-${productId}`).remove();
            } else {
                button.classList.add('bg-indigo-500', 'text-white');
                addProductRow(
                    productId,
                    button.dataset.productName,
                    button.dataset.defaultPrice
                );
            }
        }

        function addProductRow(productId, productName, defaultPrice) {
            const selectedProducts = document.getElementById('selected-products');
            const rowId = `product-row-${productId}`;
            
            if (!document.getElementById(rowId)) {
                const row = document.createElement('div');
                row.id = rowId;
                row.className = 'flex items-center gap-4 p-4 border rounded-lg';
                row.innerHTML = `
                    <div class="flex-1">
                        <strong>${productName}</strong>
                        <input type="hidden" name="products[${productId}][id]" value="${productId}">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="whitespace-nowrap">数量:
                            <input type="number" 
                                name="products[${productId}][quantity]" 
                                value="1" 
                                min="1" 
                                class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </label>
                        <label class="whitespace-nowrap">価格:
                            <input type="number" 
                                name="products[${productId}][price]" 
                                value="${defaultPrice || ''}" 
                                min="0" 
                                required
                                class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </label>
                    </div>
                `;
                selectedProducts.appendChild(row);
            }
        }
    </script>
</x-app-layout>
