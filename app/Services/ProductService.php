<?php

namespace App\Services;

class ProductService {
    
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
            'description' => $data->description,
            'purchase_price' => $data->purchase_price,
            'rent_price' => $data->rent_price,
            'rent_option' => $data->rent_option,
            'views' => $data->views ? $data->views : 0
        ];
    }

    private function formatCategory($data) {

        $category = [];

        foreach($data as $row) {

            $temp =  $row->category->name;

            array_push($category, $temp);
        }

        return implode(',', $category);
    }
}