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
        'currency'
    ];

    protected $casts = [
        'value' => MoneyCast::class . ':currency',
    ];
}
