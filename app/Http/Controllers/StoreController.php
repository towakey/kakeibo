<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

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
        ]);

        $store = new Store();
        $store->user_id = auth()->id();
        $store->name = $validated['name'];
        $store->save();

        if ($request->expectsJson()) {
            return response()->json($store);
        }

        return redirect()->route('dashboard')->with('success', '店舗を登録しました。');
    }
}
