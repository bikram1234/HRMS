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
        Schema::create('salary_advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advance_type_id');
            $table->unsignedBigInteger('user_id');
            $table->string('advance_no')->unique();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->decimal('amount', 10, 2);
            $table->unsignedTinyInteger('emi_count');
            $table->date('deduction_period'); // Add this line
            $table->text('purpose')->nullable();
            $table->string('upload_file')->nullable();
            $table->text('remarks')->nullable(); 
            $table->enum('status', ['pending', 'approved','rejected'])->default('pending'); // Add the status field


            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advance_type_id')->references('id')->on('advances');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_advances');
    }
};
