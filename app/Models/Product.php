<?php

namespace App\Models;

use Cknow\Money\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function price()
    {
        return $this->hasOne(Money::class);
    }
}
