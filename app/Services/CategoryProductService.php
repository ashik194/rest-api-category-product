<?php

namespace App\Services;

use App\Models\Category;

class CategoryProductService {

    public function getProductsByCateSlug($slug, $request)
    {
        $category = Category::where('slug', $slug)->first();
        if(empty($category))
        {
            return [];
        }

        $query = $category->products();

        switch ($request->input('sort')) {
            case 'best_sell':
                $query->withCount('orderDetails')
                      ->orderBy('order_details_count', 'desc');
                break;
            case 'top_rated':
                $query->withAvg('reviews', 'rating')
                      ->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'price_high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low_to_high':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->latest();
        }

        return $query->paginate(10);
    }
}

?>