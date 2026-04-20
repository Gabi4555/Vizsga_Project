<?php

namespace Database\Seeders;

use App\Models\Drive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DriveSeeder extends Seeder
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

        
        foreach($catfiledata as $categoryL) {

        $textfilepath = "seeders/Data/".$categoryL.".txt";

       

        $filedata = file(database_path($textfilepath), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $name = "";
     //   $price;

array_splice($filedata , 0, 2);

            $linereadcounter = 0;
        foreach ($filedata as $line) {

      $line = explode("|", $line);
    $name = trim( $line[4]);
     
      

           $exists = Drive::where('name', $name)->exists();
           if (!$exists) {
       $item = [
                    'name' => $name,
                 'created_at' => now(),
                   'updated_at' => now()

                ];
                    DB::table('Drive')->insert($item);
                
           } else { 

           }
        }
        }
    }
}
