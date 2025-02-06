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
                    <form method="POST" action="{{ route('transactions.store') }}" class="mt-6 space-y-6" id="transactionForm">
                        @csrf

                        <div>
                            <x-input-label for="transaction_date" :value="__('取引日')" />
                            <x-text-input id="transaction_date" name="transaction_date" type="date" class="mt-1 block w-full" required value="{{ date('Y-m-d') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('transaction_date')" />
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <x-input-label :value="__('店舗')" />
                                <button type="button" id="openStoreModalBtn" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus"></i> 新規店舗登録
                                </button>
                            </div>
                            <input type="hidden" name="store_id" id="store_id">
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="storeButtons">
                                @foreach($stores as $store)
                                    <button type="button"
                                            class="store-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            data-store-id="{{ $store->id }}">
                                        {{ $store->name }}
                                    </button>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('store_id')" />
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <x-input-label :value="__('商品')" />
                                <button type="button" id="openProductModalBtn" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus"></i> 新規商品登録
                                </button>
                            </div>
                            <div class="mt-2 space-y-4">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="productButtons">
                                    @foreach($products as $product)
                                        <button type="button"
                                                class="product-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-default-price="{{ $product->default_price }}">
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

    <!-- Store Modal -->
    <div id="storeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">新規店舗登録</h3>
                <form id="storeForm" class="mt-4">
                    @csrf
                    <div class="mt-2">
                        <x-input-label for="store_name" :value="__('店舗名')" />
                        <x-text-input id="store_name" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" id="closeStoreModalBtn" class="mr-2 px-4 py-2 text-gray-500 hover:text-gray-700">
                            キャンセル
                        </button>
                        <button type="button" id="submitStoreBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            登録
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">新規商品登録</h3>
                <form id="productForm" class="mt-4">
                    @csrf
                    <div class="mt-2">
                        <x-input-label for="product_name" :value="__('商品名')" />
                        <x-text-input id="product_name" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div class="mt-2">
                        <x-input-label for="product_description" :value="__('説明')" />
                        <textarea id="product_description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mt-2">
                        <x-input-label for="product_default_price" :value="__('標準価格')" />
                        <x-text-input id="product_default_price" type="number" class="mt-1 block w-full" />
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" id="closeProductModalBtn" class="mr-2 px-4 py-2 text-gray-500 hover:text-gray-700">
                            キャンセル
                        </button>
                        <button type="button" id="submitProductBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            登録
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Store Modal Functions
            $('#openStoreModalBtn').click(function() {
                $('#storeModal').removeClass('hidden');
            });

            $('#closeStoreModalBtn').click(function() {
                $('#storeModal').addClass('hidden');
                $('#store_name').val('');
            });

            $('#submitStoreBtn').click(async function() {
                const name = $('#store_name').val();
                if (!name) {
                    alert('店舗名を入力してください');
                    return;
                }

                try {
                    const response = await fetch('{{ route("stores.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({ name })
                    });

                    if (!response.ok) throw new Error('店舗の登録に失敗しました');

                    const store = await response.json();
                    const button = $('<button>')
                        .attr('type', 'button')
                        .addClass('store-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500')
                        .attr('data-store-id', store.id)
                        .text(store.name);

                    $('#storeButtons').append(button);
                    initializeStoreButton(button[0]);
                    $('#storeModal').addClass('hidden');
                    $('#store_name').val('');
                } catch (error) {
                    alert(error.message);
                }
            });

            // Product Modal Functions
            $('#openProductModalBtn').click(function() {
                $('#productModal').removeClass('hidden');
            });

            $('#closeProductModalBtn').click(function() {
                $('#productModal').addClass('hidden');
                $('#product_name').val('');
                $('#product_description').val('');
                $('#product_default_price').val('');
            });

            $('#submitProductBtn').click(async function() {
                const name = $('#product_name').val();
                const description = $('#product_description').val();
                const default_price = $('#product_default_price').val();

                if (!name) {
                    alert('商品名を入力してください');
                    return;
                }

                try {
                    const response = await fetch('{{ route("products.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({ name, description, default_price })
                    });

                    if (!response.ok) throw new Error('商品の登録に失敗しました');

                    const product = await response.json();
                    const button = $('<button>')
                        .attr('type', 'button')
                        .addClass('product-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500')
                        .attr('data-product-id', product.id)
                        .attr('data-product-name', product.name)
                        .attr('data-default-price', product.default_price);

                    let buttonContent = product.name;
                    if (product.default_price) {
                        buttonContent += `<br><span class="text-sm text-gray-600">¥${Number(product.default_price).toLocaleString()}</span>`;
                    }
                    button.html(buttonContent);

                    $('#productButtons').append(button);
                    initializeProductButton(button[0]);
                    $('#productModal').addClass('hidden');
                    $('#product_name').val('');
                    $('#product_description').val('');
                    $('#product_default_price').val('');
                } catch (error) {
                    alert(error.message);
                }
            });

            // Initialize existing buttons
            function initializeStoreButton(button) {
                $(button).click(function() {
                    $('.store-button').removeClass('bg-indigo-500 text-white');
                    $(this).addClass('bg-indigo-500 text-white');
                    $('#store_id').val($(this).data('store-id'));
                });
            }

            function initializeProductButton(button) {
                $(button).click(function() {
                    const productId = $(this).data('product-id');
                    const isSelected = $(this).hasClass('bg-indigo-500');
                    
                    if (isSelected) {
                        $(this).removeClass('bg-indigo-500 text-white');
                        $(`#product-row-${productId}`).remove();
                    } else {
                        $(this).addClass('bg-indigo-500 text-white');
                        addProductRow(
                            productId,
                            $(this).data('product-name'),
                            $(this).data('default-price')
                        );
                    }
                });
            }

            function addProductRow(productId, productName, defaultPrice) {
                const rowId = `product-row-${productId}`;
                
                if (!$(`#${rowId}`).length) {
                    const row = $('<div>')
                        .attr('id', rowId)
                        .addClass('flex items-center gap-4 p-4 border rounded-lg')
                        .html(`
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
                        `);
                    $('#selected-products').append(row);
                }
            }

            // Initialize existing buttons
            $('.store-button').each(function() {
                initializeStoreButton(this);
            });

            $('.product-button').each(function() {
                initializeProductButton(this);
            });
        });
    </script>
    @endpush
</x-app-layout>
