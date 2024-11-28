<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $products = Product::with('categories')->latest()->paginate(10);
            return ProductResource::collection($products);
        }catch(Exception $e) {
            return response()->json($e->getMessage());
        }
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
    public function store(ProductRequest $request)
    {
        // dd($request->all());
        //
        $product = $this->productService->store($request);
        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        //
        try{
            return Product::where('slug', $slug)
                            ->with(['categories', 'reviews' => function($query) {
                                $query->latest()->take(5);
                            }])->first();
        }catch(Exception $e) {
            return response()->json($e->getMessage());
        }
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
    public function update(Request $request, string $id)
    {
        //
        try{
            $product = $this->productService->update($request, $id);
            return $product;
        }catch(Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $product = Product::findOrFail($id);

            if ($product->orderDetails()->exists() || $product->reviews()->exists()) {
                return response()->json([
                    'message' => 'Cannot delete product with existing orders or reviews'
                ], 400);
            }
    
            $product->categories()->detach();
            $product->delete();

            return response()->json([
                'status' => 204,
                'message'=> "Category Deleted Successfully...."
            ]);
        }catch(Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
