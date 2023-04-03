<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'description',
      'quantity',
      'purchase_price',
      'sales_price',
    ];

    public function sales(){
        return $this->belongsToMany(Sales::class, 'product_sales')->withPivot('quantity');
    }
}
