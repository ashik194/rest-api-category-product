<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductService {
    
    public function store($request)
    {
        $product = Product::create([
            'name'  => $request->name,
            'slug'  => $request->slug,
            'price' => $request->price
        ]);

        if (isset($request->category)) {
            $product->categories()->attach($request->category);
        }

        return new ProductResource($product);
    }
    
    
    public function update($request, $id)
    {
        $product = Product::findOrFail($id);
        
        $product->update([
            'name' => $request->name ?? $product->name,
            'slug' => $request->slug ?? $product->slug,
            'price' => $request->price ?? $product->price
        ]);

        if (isset($request->categories)) {
            $product->categories()->sync($request->categories);
        }

        return new ProductResource($product);
    }
}

?>