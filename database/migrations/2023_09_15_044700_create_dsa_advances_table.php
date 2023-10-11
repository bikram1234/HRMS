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
        Schema::create('dsa_advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advance_type_id');
            $table->unsignedBigInteger('user_id');
            $table->string('advance_no')->unique();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->string('mode_of_travel')->nullable();
            $table->string('from_location')->nullable();
            $table->string('to_location')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->text('purpose')->nullable();
            $table->string('upload_file')->nullable();
            $table->text('remarks')->nullable(); 
            $table->timestamps();
            $table->enum('level1', ['pending', 'approved','rejected'])->default('pending'); 
            $table->enum('level2', ['pending', 'approved','rejected'])->default('pending'); 
            $table->enum('level3', ['pending', 'approved','rejected'])->default('pending');
            $table->enum('status', ['pending', 'approved','rejected'])->default('pending'); // Add the status field

    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advance_type_id')->references('id')->on('advances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsa_advances');
    }
};
