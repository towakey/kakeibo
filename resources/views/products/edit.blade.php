<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('商品編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('products.update', $product) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('商品名')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('説明')" />
                            <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="default_price" :value="__('標準価格')" />
                            <x-text-input id="default_price" name="default_price" type="number" class="mt-1 block w-full" :value="old('default_price', $product->default_price)" />
                            <x-input-error class="mt-2" :messages="$errors->get('default_price')" />
                        </div>

                        <div>
                            <x-input-label for="default_tax_type" :value="__('標準税率')" />
                            <select id="default_tax_type" name="default_tax_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="0" {{ old('default_tax_type', $product->default_tax_type) == 0 ? 'selected' : '' }}>非課税</option>
                                <option value="8" {{ old('default_tax_type', $product->default_tax_type) == 8 ? 'selected' : '' }}>8%</option>
                                <option value="10" {{ old('default_tax_type', $product->default_tax_type) == 10 ? 'selected' : '' }}>10%</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('default_tax_type')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('更新') }}</x-primary-button>
                            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                キャンセル
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
