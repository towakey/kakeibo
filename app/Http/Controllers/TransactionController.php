<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        \Log::info('Request data:', $request->all());

        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'store_id' => 'required|exists:stores,id',
            'products' => 'required|array|min:1',
            'products.*' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|integer|min:0',
            'products.*.tax_type' => 'required|in:0,8,10',
            'products.*.discount_amount' => 'nullable|numeric|min:0',
            'products.*.discount_rate' => 'nullable|numeric|between:0,100'
        ]);

        DB::beginTransaction();
        try {
            Log::info('Transaction data:', $validated);
            
            $transaction = new Transaction();
            $transaction->user_id = auth()->id();
            $transaction->transaction_date = $validated['transaction_date'];
            $transaction->store_id = $validated['store_id'];
            $transaction->save();

            $products = [];
            foreach ($request->products as $key => $product) {
                if (isset($product['id'], $product['quantity'], $product['price'])) {
                    Log::info('Product data:', $product);
                    $products[$product['id']] = [
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                        'tax_type' => $product['tax_type'],
                        'discount_amount' => $product['discount_amount'] ?? null,
                        'discount_rate' => $product['discount_rate'] ?? null
                    ];
                }
            }
            
            Log::info('Products to attach:', $products);
            $transaction->products()->attach($products);

            DB::commit();
            return redirect()->route('dashboard')->with('success', '取引を登録しました。');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Transaction error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
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
