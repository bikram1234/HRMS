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
        Schema::create('applied_encashments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('number_of_days'); 
            $table->double('amount'); 
            $table->enum('level1', ['pending', 'declined', 'approved'])->default('pending');
            $table->enum('level2', ['pending', 'declined', 'approved'])->default('pending');
            $table->enum('level3', ['pending', 'declined', 'approved'])->default('pending');
            $table->enum('status', ['pending', 'declined', 'approved', 'cancelled'])->default('pending');
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applied_encashments');
    }
};
