<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $categories = Category::with('parent')->latest()->paginate(10);
            return CategoryResource::collection($categories);
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
    public function store(CategoryRequest $request)
    {
        //
        $category = $this->categoryService->store($request);
        return $category;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $category = Category::with(['parent', 'children', 'products'])->findOrFail($id);
            return new CategoryResource($category);
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
            $category = $this->categoryService->update($request, $id);
            return $category;
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
             Category::where('id',$id)->delete();
            return response()->json([
                'status' => 204,
                'message'=> "Category Deleted Successfully...."
            ]);
        }catch(Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    
}
