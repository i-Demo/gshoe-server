<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/get-products', function () {
    $products = Product::with([
        'productImages:product_id,path',
        'productPrices:product_id,price'
    ])
        ->paginate(5, ['id', 'description', 'color', 'name']);


    $products->getCollection()->transform(function ($value) {

        $newArray = array_merge($value->toArray(), [
            "image" => $value->productImages->path,
            "price" => $value->productPrices->price,
        ]);

        unset($newArray['product_images'], $newArray['product_prices']);

        return $newArray;
    });

    return $products;
});
