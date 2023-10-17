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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('year');
            $table->unsignedBigInteger('holidaytype_id');
            $table->foreign('holidaytype_id')->references('id')->on('holidaytypes')->onDelete('cascade');
            $table->string('optradioholidayfrom')->nullable();
            $table->date('start_date');
            $table->string('optradioholidaylto')->nullable();
            $table->date('end_date');
            $table->decimal('number_of_days', 5, 2); // Adjust precision and scale as needed
            $table->text('description')->nullable(); // Use text for longer descriptions
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
