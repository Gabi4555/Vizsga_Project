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
 Schema::create('orderItems', function (Blueprint $table) {
            $table->id();
          $table->foreignId('order_id')
            ->constrained('orders')
            ->cascadeOnDelete(); 
        $table->foreignId('car_id')->constrained('car')->cascadeOnDelete();
        $table->integer('quantity');
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
