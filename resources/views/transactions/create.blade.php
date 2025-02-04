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
                            <x-input-label for="amount" :value="__('金額')" />
                            <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
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
            // すべての店舗ボタンから選択状態を解除
            document.querySelectorAll('.store-button').forEach(btn => {
                btn.classList.remove('bg-indigo-500', 'text-white');
                btn.classList.add('border-gray-300');
            });
            
            // クリックされたボタンを選択状態にする
            button.classList.remove('border-gray-300');
            button.classList.add('bg-indigo-500', 'text-white');
            
            // hidden inputに選択された店舗IDをセット
            document.getElementById('store_id').value = storeId;
        }
    </script>
</x-app-layout>
