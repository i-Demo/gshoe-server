<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/get-products', function () {
    $products = Product::with([
        'productImages:product_id,path',
        'productPrices:product_id,price'
    ])
        ->paginate(10, ['id', 'description', 'color', 'name']);


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