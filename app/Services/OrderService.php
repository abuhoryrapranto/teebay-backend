<?php

namespace App\Services;

class OrderService extends BaseService {
    
    public function getAllOrders($data) {

        $products = $data->map(function($item) {

            return $this->buildOrderData($item);
        });

        return $products;
    }

    public function buildOrderData($data) {

        if($data->type === 'buy') {

            $data = [
                'title' => $data->product->title,
                'category' => $this->formatCategory($data->product->productCategory),
                'description' => $data->product->description,
                'purchase_price' => $data->product->purchase_price
            ];

        } elseif($data->type === 'rent') {

            $data = [
                'title' => $data->product->title,
                'category' => $this->formatCategory($data->product->productCategory),
                'description' => $data->product->description,
                'rent_price' => $data->product->rent_price,
                'rent_option' => $data->product->rent_option
            ];
        }

        return $data;
    }
}