<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('productCategory.category')->where('status', 1)->get();

        if($products->isEmpty())
            return $this->getResponse(404, 'No products found!');
        return $this->getResponse(200, "Total {$products->count()} products found.", $this->productService->getAllProducts($products));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        DB::beginTransaction();

        try {
            
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $product->generateSlug($request->title);
            $product->description = $request->description;
            $product->purchase_price = (float) $request->purchase_price;
            $product->rent_price = (float) $request->rent_price;
            $product->rent_option = $request->rent_option;
            $product->save();

            $categories = $request->category_ids;
            
            $product_category = [];

            foreach($categories as $row) {

                $temp = [
                    'product_id' => $product->id,
                    'category_id' => $row,
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s")
                ];

                array_push($product_category, $temp);
            }

            ProductCategory::insert($product_category);

            DB::commit();

            return $this->getResponse(201, 'Product added successfully.', $product);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->getResponse(500, 'Something went wrong', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::with('productCategory.category')
                            ->where('slug', $slug)
                            ->where('status', 1)
                            ->first();

        if(!$product)
            return $this->getResponse(404, 'No products found!');
        return $this->getResponse(200, "Product found.", $this->productService->buildProductData($product));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductEditRequest $request, string $slug)
    {
        $product = Product::where('slug', $slug)->where('status', 1)->first();

        if(!$product) return $this->getResponse(404, 'Product not found!');

        DB::beginTransaction();

        try {

            $request->filled('title') ? $product->title = $request->title : '';
            $request->filled('description') ? $product->description = $request->description : '';
            $request->filled('purchase_price') ? $product->purchase_price = (float) $request->purchase_price : '';
            $request->filled('rent_price') ? $product->rent_price = (float) $request->rent_price : '';
            $request->filled('rent_option') ? $product->rent_option = $request->rent_option : '';
            $product->save();

            $categories = $request->filled('category_ids') ? $request->category_ids : '';
            
            if(count($categories) > 0) {

                $product_category = [];

                ProductCategory::where('product_id', $product->id)->delete($product_category);

                foreach($categories as $row) {

                    $temp = [
                        'product_id' => $product->id,
                        'category_id' => $row,
                        'created_at' => date("Y-m-d h:i:s"),
                        'updated_at' => date("Y-m-d h:i:s")
                    ];

                    array_push($product_category, $temp);
                }

                ProductCategory::insert($product_category);
            }

            DB::commit();

            return $this->getResponse(200, 'Product updated successfully.', $product);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->getResponse(500, 'Something went wrong', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $exit = Product::where('slug', $slug)->where('status', 1)->first();

        if(!$exit) return $this->getResponse(404, 'Product not found!');

        try {

            $exit->delete();
            ProductCategory::where('product_id', $exit->id)->where('status', 1)->delete();

            return $this->getResponse(200, 'Product deleted successfully.');

        } catch(\Exception $e) {

            return $this->getResponse(500, 'Something went wrong');
        }

    }

    public function insertProductView(string $slug) {
        
        $product = Product::where('slug', $slug)->where('status', 1)->first();
        $product->views = $product->views+1;
        
        if(!$product->save()) return $this->getResponse(500, 'Something went wrong');
        return $this->getResponse(200, 'Product view increment successfully.');
    }

    public function getAllCategories() {

        $categories = Category::where('status', 1)->get();

        if($categories->isEmpty()) 
            return $this->getResponse(404, 'Categories not found.');
        return $this->getResponse(200, "Total {$categories->count()} categories found.", $categories);

    }
}
