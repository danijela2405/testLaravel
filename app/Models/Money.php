<?php

namespace App\Models;

use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'currency',
        'product_id'
    ];

    protected $casts = [
        'value' => MoneyCast::class . ':currency',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
