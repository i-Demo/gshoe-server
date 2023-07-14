<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // protected $table = 'products';

    protected $fillables = ['name', 'color', 'description'];


    // in shoes.json, we can see product has one image, one price. so in this case, I set product has one image and one price
    public function productImages()
    {
        return $this->hasOne(Image::class, 'product_id', 'id');
    }

    public function productPrices()
    {
        return $this->hasOne(Price::class, 'product_id', 'id');
    }
}
