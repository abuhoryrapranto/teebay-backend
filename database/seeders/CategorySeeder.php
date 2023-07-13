<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => "ELECTRONICS",
                "status" => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")

            ],
            [
                'name' => "FURNITURE",
                "status" => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")

            ],
            [
                'name' => "HOME APPLIANCES",
                "status" => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")

            ],
            [
                'name' => "SPORTING GOODS",
                "status" => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")

            ],
            [
                'name' => "OUTDOOR",
                "status" => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")

            ],
            [
                'name' => "TOYS",
                "status" => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")

            ],
        ];
        
        DB::table('categories')->insert($categories);
    }
}
