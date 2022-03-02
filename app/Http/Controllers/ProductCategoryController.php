<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    // object properties
    protected $product_category;

    public function __construct(ProductCategory $pc)
    {
        $this->product_category = $pc;
    }

    // create the index function to return all the product categories
    public function index()
    {
        if(count($this->product_category::get()) < 1)
        {
            return [
                'message' => 'no product categories',
                'data' => $this->product_category->get(),
            ];
        }
        return [
            'status' => 'success',
            'data' => $this->product_category->get(),
        ];
    }

    // Function to create a product category
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $data = (object) $request->only(['category_name']);

        if(!$data)
        {
            return [
                'status' => 'failed',
                'message' => 'product category not specified',
            ];
        }
        
        $product_category = $this->product_category::create([
            'name' => strtoupper($data->category_name),
            'slug' => join("_", str_split(strtolower($data->category_name), " ")),
        ]);

        return [
            'status' => 'success',
            'data' => $product_category,
        ];

    }

}
