<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PriceHistory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'flipkart_url',
        'name',
        'image',
        'current_price',
    ];

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
