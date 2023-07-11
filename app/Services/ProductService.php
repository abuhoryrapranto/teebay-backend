<?php

namespace App\Services;

class ProductService extends BaseService {
    
    public function getAllProducts($data) {

        $products = $data->map(function($item) {

            return $this->buildProductData($item);
        });

        return $products;
    }

    public function buildProductData($data) {
        return [
            'title' => $data->title,
            'slug' => $data->slug,
            'category' => $this->formatCategory($data->productCategory),
            "category_with_id" => $this->formatCategoryWithId($data->productCategory),
            'description' => $data->description,
            'purchase_price' => number_format($data->purchase_price, 2, '.', ''),
            'rent_price' => number_format($data->rent_price, 2, '.', ''),
            'rent_option' => $data->rent_option,
            'views' => $data->views ? $data->views : 0,
            'posted_date' => $data->created_at->format('jS F Y')
        ];
    }
}