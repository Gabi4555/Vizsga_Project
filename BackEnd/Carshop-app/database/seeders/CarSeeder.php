<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
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

       $catTextfilepath = "seeders/Data/Categories.txt";
         $catfiledata = file(database_path($catTextfilepath), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


                 $brand_ids = DB::table('brand')->pluck('id', 'name');
        $carcategories_ids = DB::table('car_category')->pluck('id', 'name');
         $engine_ids = DB::table('engine')->pluck('id', 'name');
         $drive_ids = DB::table('drive')->pluck('id', 'name');
        foreach($catfiledata as $categoryL) {

        $textfilepath = "seeders/Data/".$categoryL.".txt";

       

        $filedata = file(database_path($textfilepath), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

 //   $name = "";
  
     //   $price;

array_splice($filedata , 0, 2);

            $linereadcounter = 0;
        foreach ($filedata as $line) {

      $line = explode("|", $line);
    $name = trim( $line[1]);
      
    $brand = trim( $line[2]);
    $engine = trim( $line[3]);
    $drvie = trim( $line[4]);
    $fuel_efficiency = trim( $line[4]);
    $year = trim( $line[5]);
 //   $power = trim( $line[7]);
   // $price = trim( $line[7]);
 
  $price_split = explode(  '/', $line[7]);

 

  
  
$price = str_replace(['~', ' ', '€'], '', $price_split[0]);

      $speed = trim( $line[8]);
      $accelaration = trim( $line[9]);

        
       $item = [
                    'name' => $name,
                'car_category_id' => $carcategories_ids[$categoryL],
                'brand_id' => $brand_ids[$brand],
                'engine_id'=> $engine_ids[$engine],
                'drive_id'=> $drive_ids[$drvie],
                'Year'=> $year,
                'fuel_efficiency'=> $fuel_efficiency,
             //   'power'=> $power,
                'price'=> $price,
                'speed'=> $speed,
                         'acceleration'=> $accelaration,
                 'created_at' => now(),
                   'updated_at' => now()

                ];
                    DB::table('car')->insert($item);
        
        }
        }
    }
}
