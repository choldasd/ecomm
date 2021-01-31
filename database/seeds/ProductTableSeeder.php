<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'product_name' => "Acer Aspire 5",
            'product_price' => 32000.55,
            'product_desccription' => "This is latest version of laptop with new intel i5 version cpuprocessor,8GB DDR4 RAM and SSD.",
            'product_image' => "laptop1.jpg,laptop2.jpg,",            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'product_name' => "Acer Aspire 3",
            'product_price' => 31599.99,
            'product_desccription' => "This is latest version of laptop with new intel i5 version cpuprocessor,8GB DDR4 RAM and SSD.",
            'product_image' => "laptop3.jpg,laptop4.jpg,",            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
