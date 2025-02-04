<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Productモデルをインポートする

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
        $product->description = $validated['description'];
        $product->default_price = $validated['default_price'];
        $product->save();

        return redirect()->route('dashboard')->with('success', '商品を登録しました。');
    }
}
