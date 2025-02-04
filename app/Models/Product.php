<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'default_price'
    ];

    protected $casts = [
        'default_price' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
