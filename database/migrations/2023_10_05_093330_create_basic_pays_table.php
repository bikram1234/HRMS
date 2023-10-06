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
        Schema::create('basic_pays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grade_id');
            $table->decimal('amount', 10, 2); // Change the precision and scale as needed
            $table->timestamps();

            // Define a foreign key constraint to relate to the 'grades' table
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_pays');
    }
};
