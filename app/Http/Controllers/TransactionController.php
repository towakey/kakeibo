<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create()
    {
        $stores = Store::where('user_id', auth()->id())->get();
        $products = Product::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('stores', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'store_id' => 'required|exists:stores,id',
            'products' => 'required|array|min:1',
            'products.*' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|integer|min:0'
        ]);

        DB::beginTransaction();
        try {
            $transaction = new Transaction();
            $transaction->user_id = auth()->id();
            $transaction->transaction_date = $validated['transaction_date'];
            $transaction->store_id = $validated['store_id'];
            $transaction->save();

            $products = [];
            foreach ($request->products as $key => $product) {
                if (isset($product['id'], $product['quantity'], $product['price'])) {
                    $products[$product['id']] = [
                        'quantity' => $product['quantity'],
                        'price' => $product['price']
                    ];
                }
            }
            
            $transaction->products()->attach($products);

            DB::commit();
            return redirect()->route('dashboard')->with('success', '取引を登録しました。');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', '取引の登録に失敗しました。')->withInput();
        }
    }

    public function index()
    {
        $transactions = Transaction::with(['store', 'products'])
            ->where('user_id', auth()->id())
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('dashboard', compact('transactions'));
    }
}
