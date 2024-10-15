<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = DB::connection('old_mysql')->table('products')->get();

        foreach ($products as $product) {
            DB::table('products')->insert([
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'price' => $product->price,
                'image' => $product->image,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at
            ]);
        }
    }
}
