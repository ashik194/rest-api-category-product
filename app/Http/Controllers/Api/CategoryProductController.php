<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryProductService;
use Exception;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    //
    public function __construct(private readonly CategoryProductService $categoryProductService)
    {
        
    }

    public function getProducts($slug, Request $request)
    {
        try{
            $products = $this->categoryProductService->getProductsByCateSlug($slug, $request);
            if(!empty($products))
            {
                return $products;
            }
            return response()->json(["message" => "Please provide the correct slug"],400);
        }catch(Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
