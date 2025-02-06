<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_price' => 'nullable|integer|min:0',
        ]);

        $product = new Product();
        $product->user_id = auth()->id();
        $product->name = $validated['name'];
        $product->description = $validated['description'] ?? null;
        $product->default_price = $validated['default_price'] ?? null;
        $product->save();

        if ($request->expectsJson()) {
            return response()->json($product);
        }

        return redirect()->route('dashboard')->with('success', '商品を登録しました。');
    }
}
