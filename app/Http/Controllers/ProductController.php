<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $products = Product::where('user_id', auth()->id())->orderBy('name')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_price' => 'nullable|numeric|min:0',
            'default_tax_type' => 'required|in:0,8,10'
        ]);

        $validated['user_id'] = auth()->id();
        $product = Product::create($validated);

        if ($request->expectsJson()) {
            return response()->json($product);
        }

        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_price' => 'nullable|numeric|min:0',
            'default_tax_type' => 'required|in:0,8,10'
        ]);

        $product->name = $validated['name'];
        $product->description = $validated['description'] ?? null;
        $product->default_price = $validated['default_price'] ?? null;
        $product->default_tax_type = $validated['default_tax_type'];
        $product->save();

        return redirect()->route('products.index')->with('success', '商品情報を更新しました。');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
