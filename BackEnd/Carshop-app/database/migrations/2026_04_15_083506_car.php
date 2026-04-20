<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //

              Schema::create('car', function (Blueprint $table) {
            $table->id();
        
           
            $table->string('name');
            $table->foreignId('car_category_id')
            ->constrained('car_category')
            ->cascadeOnDelete(); 
              $table->foreignId('brand_id')
            ->constrained('brand')
            ->cascadeOnDelete();
    $table->foreignId('engine_id')
            ->constrained('engine')
            ->cascadeOnDelete();
  $table->foreignId('drive_id')
            ->constrained('drive')
            ->cascadeOnDelete();
            $table->year('year');//->default(2007);
$table->string('fuel_efficiency');

 //   $table->integer('power');
    $table->string('price');
  //  $table->decimal('to_make_price',8,2)->nullable();
  //  $table->foreignId('agility_id')
 //           ->constrained('agility')
  //          ->cascadeOnDelete();


    $table->string('speed');
    $table->string('acceleration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
