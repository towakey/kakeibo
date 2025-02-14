<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransactionController extends Controller
{
    use AuthorizesRequests;

    public function create()
    {
        $stores = Store::where('user_id', auth()->id())->get();
        $products = Product::where('user_id', auth()->id())->get();
        $categories = Category::where(function($query) {
            $query->whereNull('user_id')
                  ->orWhere('user_id', auth()->id());
        })->get();
        return view('transactions.create', compact('stores', 'products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => ['required', 'date'],
            'store_id' => ['required', 'exists:stores,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.price' => ['required', 'integer', 'min:0'],
            'products.*.tax_type' => ['required', 'integer', 'min:0'],
            'products.*.discount_amount' => ['nullable', 'integer', 'min:0'],
            'products.*.discount_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'transaction_date' => $validated['transaction_date'],
            'store_id' => $validated['store_id'],
            'category_id' => $validated['category_id'],
        ]);

        foreach ($validated['products'] as $product) {
            $transaction->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'tax_type' => $product['tax_type'],
                'discount_amount' => $product['discount_amount'] ?? 0,
                'discount_rate' => $product['discount_rate'] ?? 0,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', '取引を登録しました。');
    }

    public function index()
    {
        $transactions = Transaction::with(['store', 'products', 'category'])
            ->where('user_id', auth()->id())
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);
        
        return view('transactions.index', compact('transactions'));
    }

    /**
     * 指定された取引を削除
     */
    public function destroy(Transaction $transaction)
    {
        // 認可チェック
        $this->authorize('delete', $transaction);

        try {
            // トランザクションを開始
            DB::beginTransaction();

            // 関連する商品を削除
            $transaction->products()->detach();

            // 取引を削除
            $transaction->delete();

            // トランザクションをコミット
            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', '取引を削除しました。');

        } catch (\Exception $e) {
            // エラー時はロールバック
            DB::rollBack();
            
            return redirect()->route('transactions.index')
                ->with('error', '取引の削除に失敗しました。');
        }
    }
}
