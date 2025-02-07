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
                                <button type="button" id="showStoreModalBtn" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus"></i> 新規店舗登録
                                </button>
                            </div>
                            <input type="hidden" name="store_id" id="selected_store_id" value="{{ old('store_id') }}">
                            <div id="storeButtons" class="mt-2 flex flex-wrap gap-2">
                                @foreach (Auth::user()->stores()->orderBy('name')->get() as $store)
                                    <button type="button"
                                        class="store-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ old('store_id') == $store->id ? 'bg-indigo-500 text-white' : '' }}"
                                        data-store-id="{{ $store->id }}"
                                        data-store-name="{{ $store->name }}">
                                        {{ $store->name }}
                                    </button>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('store_id')" />
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <x-input-label :value="__('カテゴリ')" />
                                <button type="button" id="showCategoryModalBtn" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus"></i> 新規カテゴリ登録
                                </button>
                            </div>
                            <input type="hidden" name="category_id" id="selected_category_id" value="{{ old('category_id') }}">
                            <div id="categoryButtons" class="mt-2 flex flex-wrap gap-2">
                                @foreach (Auth::user()->categories()->orderBy('name')->get() as $category)
                                    <button type="button"
                                        class="category-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ old('category_id') == $category->id ? 'bg-indigo-500 text-white' : '' }}"
                                        data-category-id="{{ $category->id }}"
                                        data-category-name="{{ $category->name }}">
                                        {{ $category->name }}
                                    </button>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <x-input-label :value="__('商品')" />
                                <button type="button" id="showProductModalBtn" class="text-sm text-blue-600 hover:text-blue-800">
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
                                                data-default-price="{{ $product->default_price }}"
                                                data-default-tax-type="{{ $product->default_tax_type }}">
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
                        <button type="button" id="closeStoreModalBtn" class="mr-2 px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 border border-gray-300">
                            キャンセル
                        </button>
                        <button type="button" id="submitStoreBtn" class="px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 border border-red-700 shadow-sm">
                            登録する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- カテゴリ登録モーダル -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900">カテゴリ登録</h3>
                <div class="mt-2 px-7 py-3">
                    <form id="categoryForm">
                        <div class="mb-4">
                            <label for="category_name" class="block text-sm font-medium text-gray-700">カテゴリ名</label>
                            <input type="text" id="category_name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="category_description" class="block text-sm font-medium text-gray-700">説明</label>
                            <textarea id="category_description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeCategoryModalBtn" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        キャンセル
                    </button>
                    <button id="saveCategoryBtn" class="mt-3 px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        登録
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900">商品登録</h3>
                <div class="mt-2 px-7 py-3">
                    <form id="productForm">
                        <div class="mb-4">
                            <label for="product_name" class="block text-sm font-medium text-gray-700">商品名</label>
                            <input type="text" id="product_name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="product_description" class="block text-sm font-medium text-gray-700">説明</label>
                            <textarea id="product_description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="product_price" class="block text-sm font-medium text-gray-700">標準価格</label>
                            <input type="number" id="product_price" name="default_price" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="product_tax_type" class="block text-sm font-medium text-gray-700">標準税率</label>
                            <select id="product_tax_type" name="default_tax_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="0">非課税</option>
                                <option value="8">8%</option>
                                <option value="10" selected>10%</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeProductModalBtn" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        キャンセル
                    </button>
                    <button id="saveProductBtn" class="mt-3 px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        登録
                    </button>
                </div>
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
            $('#showProductModalBtn').on('click', function() {
                $('#productModal').removeClass('hidden');
            });

            $('#closeProductModalBtn').on('click', function() {
                $('#productModal').addClass('hidden');
                $('#productForm')[0].reset();
            });

            $('#saveProductBtn').on('click', function() {
                const formData = {
                    name: $('#product_name').val(),
                    description: $('#product_description').val(),
                    default_price: $('#product_price').val(),
                    default_tax_type: $('#product_tax_type').val()
                };

                $.ajax({
                    url: '{{ route('products.store') }}',
                    method: 'POST',
                    data: {
                        ...formData,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Product created:', response);
                        
                        // 新しい商品ボタンを作成
                        const button = $('<button>')
                            .attr('type', 'button')
                            .addClass('product-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500')
                            .attr('data-product-id', response.id)
                            .attr('data-product-name', response.name)
                            .attr('data-default-price', response.default_price)
                            .attr('data-default-tax-type', response.default_tax_type);

                        // 商品名を設定
                        const nameText = response.name;
                        if (response.default_price) {
                            button.html(`${nameText}<br><span class="text-sm text-gray-600">¥${Number(response.default_price).toLocaleString()}</span>`);
                        } else {
                            button.text(nameText);
                        }

                        // 商品ボタンを追加
                        $('#productButtons').append(button);
                        initializeProductButton(button[0]);

                        // モーダルを閉じてフォームをリセット
                        $('#productModal').addClass('hidden');
                        $('#productForm')[0].reset();
                    },
                    error: function(xhr) {
                        console.error('Product creation error:', xhr);
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'エラーが発生しました：\n';
                        for (const key in errors) {
                            errorMessage += `${errors[key]}\n`;
                        }
                        alert(errorMessage);
                    }
                });
            });

            // カテゴリボタンの機能
            function initializeCategoryButton(button) {
                $(button).on('click', function() {
                    const categoryId = $(this).data('category-id');
                    const categoryName = $(this).data('category-name');
                    
                    // 他のボタンの選択を解除
                    $('.category-button').removeClass('bg-indigo-500 text-white');
                    
                    // このボタンを選択状態に
                    $(this).addClass('bg-indigo-500 text-white');
                    
                    // hidden inputに値を設定
                    $('#selected_category_id').val(categoryId);
                });
            }

            // 既存のカテゴリボタンを初期化
            $('.category-button').each(function() {
                initializeCategoryButton(this);
            });

            // カテゴリモーダルの機能
            $('#showCategoryModalBtn').on('click', function() {
                $('#categoryModal').removeClass('hidden');
            });

            $('#closeCategoryModalBtn').on('click', function() {
                $('#categoryModal').addClass('hidden');
                $('#categoryForm')[0].reset();
            });

            $('#saveCategoryBtn').on('click', function() {
                const formData = {
                    name: $('#category_name').val(),
                    description: $('#category_description').val(),
                };

                $.ajax({
                    url: '{{ route('categories.store') }}',
                    method: 'POST',
                    data: {
                        ...formData,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Category created:', response);
                        
                        // 新しいカテゴリボタンを作成
                        const button = $('<button>')
                            .attr('type', 'button')
                            .addClass('category-button py-2 px-4 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500')
                            .attr('data-category-id', response.id)
                            .attr('data-category-name', response.name)
                            .text(response.name);

                        // カテゴリボタンを追加
                        $('#categoryButtons').append(button);
                        initializeCategoryButton(button[0]);

                        // 新しいカテゴリを選択状態に
                        button.trigger('click');

                        // モーダルを閉じてフォームをリセット
                        $('#categoryModal').addClass('hidden');
                        $('#categoryForm')[0].reset();
                    },
                    error: function(xhr) {
                        console.error('Category creation error:', xhr);
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'エラーが発生しました：\n';
                        for (const key in errors) {
                            errorMessage += `${errors[key]}\n`;
                        }
                        alert(errorMessage);
                    }
                });
            });

            // Initialize existing buttons
            function initializeStoreButton(button) {
                $(button).click(function() {
                    $('.store-button').removeClass('bg-indigo-500 text-white');
                    $(this).addClass('bg-indigo-500 text-white');
                    $('#selected_store_id').val($(this).data('store-id'));
                });
            }

            function initializeProductButton(button) {
                $(button).on('click', function() {
                    const productId = $(this).data('product-id');
                    const productName = $(this).data('product-name');
                    const defaultPrice = $(this).data('default-price');
                    const defaultTaxType = $(this).data('default-tax-type');
                    const rowId = `product-row-${productId}`;
                    
                    // 商品が既に選択されているか確認
                    if ($(`#${rowId}`).length) {
                        // 選択解除
                        $(`#${rowId}`).remove();
                        $(this).removeClass('bg-indigo-500 text-white');
                    } else {
                        // 新規選択
                        $(this).addClass('bg-indigo-500 text-white');
                        addProductRow(productId, productName, defaultPrice, defaultTaxType);
                    }
                });
            }

            function addProductRow(productId, productName, defaultPrice, defaultTaxType) {
                const rowId = `product-row-${productId}`;
                console.log('Adding product row:', { productId, productName, defaultPrice, defaultTaxType });
                
                if (!$(`#${rowId}`).length) {
                    const row = $('<div>')
                        .attr('id', rowId)
                        .addClass('flex items-center gap-4 p-4 border rounded-lg product-row')
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
                                        class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 product-quantity">
                                </label>
                                <label class="whitespace-nowrap">消費税:
                                    <select name="products[${productId}][tax_type]" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 product-tax">
                                        <option value="0" ${defaultTaxType == 0 ? 'selected' : ''}>非課税</option>
                                        <option value="8" ${defaultTaxType == 8 ? 'selected' : ''}>8%</option>
                                        <option value="10" ${defaultTaxType == 10 ? 'selected' : ''}>10%</option>
                                    </select>
                                </label>
                                <label class="whitespace-nowrap">割引額:
                                    <input type="number" 
                                        name="products[${productId}][discount_amount]" 
                                        step="0.01" 
                                        placeholder="割引額" 
                                        class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 product-discount-amount">
                                </label>
                                <label class="whitespace-nowrap">割引率:
                                    <input type="number" 
                                        name="products[${productId}][discount_rate]" 
                                        step="0.01" 
                                        placeholder="割引率" 
                                        class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 product-discount-rate">
                                </label>
                                <label class="whitespace-nowrap">価格:
                                    <input type="number" 
                                        name="products[${productId}][price]" 
                                        value="${defaultPrice || ''}" 
                                        min="0" 
                                        required
                                        class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 product-price"
                                        data-base-price="${defaultPrice || 0}">
                                </label>
                            </div>
                        `);
                    $('#selected-products').append(row);
                    console.log('Product row added:', row.html());
                    
                    // 価格計算のイベントリスナーを設定
                    const productRow = $(`#${rowId}`);
                    setupPriceCalculation(productRow);
                }
            }

            function setupPriceCalculation(productRow) {
                const quantityInput = productRow.find('.product-quantity');
                const discountAmountInput = productRow.find('.product-discount-amount');
                const discountRateInput = productRow.find('.product-discount-rate');
                const priceInput = productRow.find('.product-price');
                const taxTypeSelect = productRow.find('select.product-tax');
                const basePrice = parseFloat(priceInput.data('base-price')) || 0;

                const calculatePrice = () => {
                    const quantity = parseFloat(quantityInput.val()) || 1;
                    const taxRate = parseFloat(taxTypeSelect.val()) || 0;
                    const discountAmount = parseFloat(discountAmountInput.val()) || 0;
                    const discountRate = parseFloat(discountRateInput.val()) || 0;
                    
                    // 基本価格 × 数量
                    let price = basePrice;
                    
                    // 割引額を適用
                    if (discountAmount > 0) {
                        price = price - discountAmount;
                    }
                    
                    // 割引率を適用
                    if (discountRate > 0) {
                        price = price * (1 - discountRate / 100);
                    }
                    
                    // 消費税を適用
                    if (taxRate > 0) {
                        price = price * (1 + taxRate / 100);
                    }
                    
                    // 数量を乗算
                    price = price * quantity;
                    
                    // 小数点以下を切り捨て
                    price = Math.floor(price);
                    
                    console.log('calculatePrice called:', {
                        basePrice,
                        quantity,
                        taxRate,
                        discountAmount,
                        discountRate,
                        finalPrice: price
                    });

                    // 計算結果を価格フィールドに設定
                    priceInput.val(Math.max(0, price));
                };

                // イベントリスナーを設定
                quantityInput.on('input', calculatePrice);
                taxTypeSelect.on('change', calculatePrice);
                discountAmountInput.on('input', () => {
                    if (discountAmountInput.val()) {
                        discountRateInput.val('');
                    }
                    calculatePrice();
                });
                discountRateInput.on('input', () => {
                    if (discountRateInput.val()) {
                        discountAmountInput.val('');
                    }
                    calculatePrice();
                });

                // 初期計算
                calculatePrice();
            }

            // Initialize existing buttons
            $('.store-button').each(function() {
                initializeStoreButton(this);
            });

            $('.product-button').each(function() {
                initializeProductButton(this);
            });

            // フォーム送信時のデータをコンソールに出力
            $('#transactionForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serializeArray();
                console.log('Form data:', formData);
                
                // フォームデータの詳細をコンソールに出力
                const formObject = {};
                formData.forEach(item => {
                    formObject[item.name] = item.value;
                });
                console.log('Form data as object:', formObject);
                
                // 選択された商品の情報を出力
                console.log('Selected products:', $('#selected-products').find('input').serializeArray());
                
                // フォームデータを確認
                const hasStoreId = $('#selected_store_id').val();
                const hasCategoryId = $('#selected_category_id').val();
                const hasProducts = $('#selected-products').children().length > 0;
                
                if (!hasStoreId) {
                    alert('店舗を選択してください。');
                    return false;
                }
                
                if (!hasCategoryId) {
                    alert('カテゴリを選択してください。');
                    return false;
                }
                
                if (!hasProducts) {
                    alert('商品を1つ以上選択してください。');
                    return false;
                }
                
                this.submit();
            });
        });
    </script>
    @endpush
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('Transaction create page script loaded');
  function recalcPrice(productRow) {
    const quantityInput = productRow.querySelector('input.product-quantity');
    const taxSelect = productRow.querySelector('select.product-tax');
    const discountAmountInput = productRow.querySelector('input.product-discount-amount');
    const discountRateInput = productRow.querySelector('input.product-discount-rate');
    const priceInput = productRow.querySelector('input.product-price');
    
    const basePrice = parseFloat(priceInput.getAttribute('data-base-price')) || 0;
    const quantity = parseFloat(quantityInput.value) || 1;
    const taxRate = parseFloat(taxSelect.value) || 0;
    const discountAmount = parseFloat(discountAmountInput.value) || 0;
    const discountRate = parseFloat(discountRateInput.value) || 0;
    
    let price = basePrice;
    
    // 割引額を適用
    if (discountAmount > 0) {
      price = price - discountAmount;
    }
    
    // 割引率を適用
    if (discountRate > 0) {
      price = price * (1 - discountRate / 100);
    }
    
    // 消費税を適用
    if (taxRate > 0) {
      price = price * (1 + taxRate / 100);
    }
    
    // 数量を乗算
    price = price * quantity;
    
    // 小数点以下を切り捨て
    price = Math.floor(price);
    
    console.log('recalcPrice called:', {
      basePrice,
      quantity,
      taxRate,
      discountAmount,
      discountRate,
      finalPrice: price
    });

    // 計算結果を価格フィールドに設定
    priceInput.value = price;
  }
  
  document.addEventListener('input', function(e) {
    console.log('input event captured:', e.target);
    const target = e.target;
    if (target.matches('input.product-quantity, select.product-tax, input.product-discount-amount, input.product-discount-rate')) {
      const row = target.closest('.product-row');
      if (row) {
        recalcPrice(row);
      } else {
        console.log('No product-row container found for target:', target);
      }
    }
  });
  
  document.addEventListener('change', function(e) {
    console.log('change event captured:', e.target);
    const target = e.target;
    if (target.matches('input.product-quantity, select.product-tax, input.product-discount-amount, input.product-discount-rate')) {
      const row = target.closest('.product-row');
      if (row) {
        recalcPrice(row);
      } else {
        console.log('No product-row container found for target:', target);
      }
    }
  });
});
</script>
