<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

             DB::listen(function ($query) {
    logger($query->sql, $query->bindings);
    }); 

         $textfilepath = "seeders/Data/Categories.txt";

        $categoryarray = [];
        $filedata = file(database_path($textfilepath), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        

        foreach ($filedata as $line) {
                
                $item = [
                    'name' => $line,
                 'created_at' => now(),
                   'updated_at' => now()

                ];
                $categoryarray[] = $item;    
        }

            DB::table('car_category')->insert($categoryarray);
    }
}
