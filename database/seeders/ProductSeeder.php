<?php

namespace Database\Seeders;

use App\Models\Product;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // parse json to array php
        try {
            $data = json_decode(File::get(base_path('./public/shoes.json')));

            // array of shoes
            $shoes = $data->shoes;

            DB::beginTransaction();
            try {
                foreach ($shoes as $value) {
                    $product = Product::create([
                        'name' => $value->name,
                        'color' => $value->color,
                        'description' => $value->description
                    ]);

                    $product->productImages()->create([
                        'name' => $value->name,
                        'path' => $value->image,
                        'product_id' => $product->id
                    ]);

                    $product->productPrices()->create([
                        'price' => $value->price,
                        'product_id' => $product->id
                    ]);
                }

                DB::commit();
            } catch (\Throwable $th) {
                throw new Exception('Error when insert data to database!');
            }
        } catch (\Throwable $th) {
            throw new Exception('Error when parse json!');
        }
    }
}
