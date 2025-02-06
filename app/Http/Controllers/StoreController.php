<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $stores = Store::where('user_id', auth()->id())->orderBy('name')->get();
        return view('stores.index', compact('stores'));
    }

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

        return redirect()->route('stores.index')->with('success', '店舗を登録しました。');
    }

    public function edit(Store $store)
    {
        $this->authorize('update', $store);
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $this->authorize('update', $store);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store->name = $validated['name'];
        $store->save();

        return redirect()->route('stores.index')->with('success', '店舗情報を更新しました。');
    }

    public function destroy(Store $store)
    {
        $this->authorize('delete', $store);
        
        $store->delete();
        return redirect()->route('stores.index')->with('success', '店舗を削除しました。');
    }
}
