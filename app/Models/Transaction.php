<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'transaction_date'
    ];

    protected $casts = [
        'transaction_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
