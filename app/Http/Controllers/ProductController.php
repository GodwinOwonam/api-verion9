<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    // let's add some properties
    protected $product;
    protected $product_category;

    public function __construct(Product $product, ProductCategory $product_category)
    {
        $this->product = $product;
        $this->product_category = $product_category;
    }

    // function to get all the products available in the database
    public function index()
    {
        return $this->product::get();
    } 

    // function to create a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        $data = (object) $request;

        if(!$this->product_category::find($data->category_id))
        {
            return [
                'status_code' => 404,
                'message' => 'product category not found',
            ];
        }

        $fields = [
            'name' => strtolower($data->name),
            'price' => $data->price,
            'description' => $data->description,
            'category_id' => $data->category_id,
        ];

        
        $product = $this->product::create($fields);

        if(!$product)
        {
            return [
                'status_code' => 422,
                'status' => 'failed',
                'message' => 'Product creation failed',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product,
        ];
        
    }


    // function to find a particular product by id
    public function show($product_id)
    {
        if(!$this->product::find($product_id))
        {
            return [
                'status_code' => 404,
                'message' => 'product not found',
            ];
        }

        $response = [
            'status' => 'success',
            'data' => $this->product::find($product_id),
        ];

        return response($response, 200);
    }

    // function to search for a product by its name
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required',
        ]);

        $data = (object) $request->only(['query']);

        // return $data;

        $products = $this->product::where('name', 'like', '%'.$data->query.'%')->get();
        // return $products;

        if(count($products) < 1)
        {
            return [
                'status_code' => 404,
                'message' => 'no product by that name',
                'data' => $products,
            ];
        }

        return [
            'status' => 'success',
            'data' => $products,
        ];

    }

    // Function to sort product by name
    public function sortProducts()
    {
        if(count($this->product::get()) < 1)
        {
            return [
                'message' => 'cannot sort: no products available.',
            ];
        }

        $products =  $this->product::get()->sortBy('name');
        // $products->sortBy('name');
        // $sortedProducts = sort()

        return [
            'status' => 'success',
            'message' => 'product sorting successful: ordered by name',
            'data' => $products,
        ];
    }

    // function to modify product properties
    public function edit(Request $request, $product_id)
    {
        if(!$this->product::find($product_id))
        {
            return [
                'status_code' => 404,
                'message' => 'cannot update product: product not found'
            ];
        }

        $product = $this->product::find($product_id);
        $product->update($request->all());
        return [
            'status' => 'success',
            'data' => $product,
        ];
    }

    // function to destroy a product
    public function destroy($product_id)
    {
        if(!$this->product::find($product_id))
        {
            return [
                'status_code' => 404,
                'message' => 'cannot destroy: product not found',
            ];
        }

        return [
            'status' => 'success',
            'message' => $this->product::destroy($product_id),
        ];
    }
}
