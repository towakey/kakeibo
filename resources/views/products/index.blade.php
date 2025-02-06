<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('商品管理') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">商品一覧</h3>
                        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            新規商品登録
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mt-6 space-y-4">
                        @foreach($products as $product)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">{{ $product->name }}</h4>
                                    @if($product->description)
                                        <p class="text-sm text-gray-600">{{ $product->description }}</p>
                                    @endif
                                    @if($product->default_price)
                                        <p class="text-sm text-gray-600">標準価格: ¥{{ number_format($product->default_price) }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                        編集
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('この商品を削除してもよろしいですか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        @if($products->isEmpty())
                            <p class="text-gray-500 text-center py-4">商品が登録されていません。</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
