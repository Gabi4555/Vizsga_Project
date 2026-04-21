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
                           Schema::create('orderLocationInfoes', function (Blueprint $table) {
            $table->id();
          $table->foreignId('order_id')
            ->constrained('orders')
            ->cascadeOnDelete(); 
        $table->string('country');
        $table->string('city');
        $table->string('street');
        $table->string('house');

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
