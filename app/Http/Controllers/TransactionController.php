<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;

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
            'amount' => 'required|integer',
            'transaction_date' => 'required|date',
            'store_id' => 'nullable|exists:stores,id',
            'product_id' => 'nullable|exists:products,id'
        ]);

        $transaction = new Transaction();
        $transaction->user_id = auth()->id();
        $transaction->amount = $validated['amount'];
        $transaction->transaction_date = $validated['transaction_date'];
        $transaction->store_id = $validated['store_id'];
        $transaction->product_id = $validated['product_id'];
        $transaction->save();

        return redirect()->route('dashboard')->with('success', '取引を登録しました。');
    }

    public function index()
    {
        $transactions = Transaction::with(['store', 'product'])
            ->where('user_id', auth()->id())
            ->orderBy('transaction_date', 'desc')
            ->get();
        
        return view('dashboard', compact('transactions'));
    }
}
