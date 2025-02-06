<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('取引履歴') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($transactions->isEmpty())
                        <p class="text-gray-500">{{ __('取引データがありません。') }}</p>
                    @else
                        <div class="space-y-6">
                            @foreach($transactions as $transaction)
                                <div class="border rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <div class="font-semibold">{{ $transaction->transaction_date->format('Y/m/d') }}</div>
                                            @if($transaction->store)
                                                <div class="text-gray-600">{{ $transaction->store->name }}</div>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-lg">
                                                ¥{{ number_format($transaction->products->sum(function($product) {
                                                    return $product->pivot->price * $product->pivot->quantity;
                                                })) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        @foreach($transaction->products as $product)
                                            <div class="flex justify-between items-center text-sm text-gray-600">
                                                <div>{{ $product->name }}</div>
                                                <div class="flex items-center gap-4">
                                                    <span>{{ $product->pivot->quantity }}個</span>
                                                    <span>¥{{ number_format($product->pivot->price) }}</span>
                                                    <span class="font-medium">
                                                        ¥{{ number_format($product->pivot->price * $product->pivot->quantity) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('新規取引登録') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
