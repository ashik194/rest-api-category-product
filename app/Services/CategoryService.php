<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService {
    
    public function store($request)
    {
        $category = Category::create([
            'name'      => $request->name,
            'slug'      => $request->slug,
            'parent_id' => $request->parent_id
        ]);

        return new CategoryResource($category);
    }
    
    
    public function update($request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name'      => $request->name,
            'slug'      => $request->slug,
            'parent_id' => $request->parent_id
        ]);
        return new CategoryResource($category);
    }
}

?>