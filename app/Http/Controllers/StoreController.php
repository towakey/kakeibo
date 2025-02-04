<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store; // Storeモデルを使用するため、use文を追加

class StoreController extends Controller
{
    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $store = new Store();
        $store->user_id = auth()->id();
        $store->name = $validated['name'];
        $store->description = $validated['description'];
        $store->save();

        return redirect()->route('dashboard')->with('success', '店舗を登録しました。');
    }
}
