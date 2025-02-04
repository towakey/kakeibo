<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer',
            'transaction_date' => 'required|date',
        ]);

        $transaction = new Transaction();
        $transaction->user_id = auth()->id();
        $transaction->amount = $validated['amount'];
        $transaction->transaction_date = $validated['transaction_date'];
        $transaction->save();

        return redirect()->route('dashboard')->with('success', '取引を登録しました。');
    }
}
