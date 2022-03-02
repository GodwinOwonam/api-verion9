<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some product categories if there are none

        if(!DB::table('product_categories')->count())
        {
            ProductCategory::create([
                'name' => 'Headsets',
                'slug' => 'headsets',
            ]);

            ProductCategory::create([
                'name' => 'Screen Guard',
                'slug' => 'screen_guard',
            ]);
        }
    }
}
