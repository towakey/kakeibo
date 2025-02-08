<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * 取引の削除権限をチェック
     */
    public function delete(User $user, Transaction $transaction)
    {
        return $user->id === $transaction->user_id;
    }
}
