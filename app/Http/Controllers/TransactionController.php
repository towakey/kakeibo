<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Store;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create()
    {
        $stores = Store::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer',
            'transaction_date' => 'required|date',
            'store_id' => 'nullable|exists:stores,id'
        ]);

        $transaction = new Transaction();
        $transaction->user_id = auth()->id();
        $transaction->amount = $validated['amount'];
        $transaction->transaction_date = $validated['transaction_date'];
        $transaction->store_id = $validated['store_id'];
        $transaction->save();

        return redirect()->route('dashboard')->with('success', '取引を登録しました。');
    }

    public function index()
    {
        $transactions = Transaction::with('store')
            ->where('user_id', auth()->id())
            ->orderBy('transaction_date', 'desc')
            ->get();
        
        return view('dashboard', compact('transactions'));
    }
}
