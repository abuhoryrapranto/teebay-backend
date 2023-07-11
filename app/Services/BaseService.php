<?php

namespace App\Services;

class BaseService {

    protected function formatCategory($data) {

        $category = [];

        foreach($data as $row) {

            $temp =  $row->category->name;

            array_push($category, $temp);
        }

        return implode(',', $category);
    }

    protected function formatCategoryWithId($data) {

        $category = [];

        foreach($data as $row) {

            $temp =  [
                'value' => $row->category->id,
                'label' => $row->category->name
            ];

            array_push($category, $temp);
        }

        return $category;
    }
}