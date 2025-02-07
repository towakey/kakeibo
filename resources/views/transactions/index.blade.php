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
                    <div class="mb-4">
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            新規取引登録
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">取引日</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">店舗</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">商品</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">合計金額</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaction->transaction_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaction->store->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="space-y-2">
                                                @foreach($transaction->products as $product)
                                                    <div class="border-b border-gray-200 pb-2 last:border-b-0 last:pb-0">
                                                        <div class="font-medium">{{ $product->name }}</div>
                                                        <div class="text-sm text-gray-600">
                                                            数量: {{ $product->pivot->quantity }}
                                                            <span class="mx-1">|</span>
                                                            単価: ¥{{ number_format($product->pivot->price / $product->pivot->quantity) }}
                                                            @if($product->pivot->discount_amount > 0)
                                                                <span class="mx-1">|</span>
                                                                割引額: ¥{{ number_format($product->pivot->discount_amount) }}
                                                            @endif
                                                            @if($product->pivot->discount_rate > 0)
                                                                <span class="mx-1">|</span>
                                                                割引率: {{ $product->pivot->discount_rate }}%
                                                            @endif
                                                            <span class="mx-1">|</span>
                                                            税率: {{ $product->pivot->tax_type }}%
                                                            <span class="mx-1">|</span>
                                                            小計: ¥{{ number_format($product->pivot->price) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ¥{{ number_format($transaction->products->sum('pivot.price')) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('本当に削除しますか？')">
                                                    削除
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
