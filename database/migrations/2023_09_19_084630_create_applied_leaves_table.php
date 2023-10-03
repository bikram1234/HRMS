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
        Schema::create('applied_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('leave_id');
            $table->foreign('leave_id')->references('id')->on('leavetypes')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('number_of_days'); // Renamed 'no.of.Days' to 'number_of_days'
            $table->string('remark')->nullable();
            $table->string('file_path')->nullable(); // Changed 'file' to 'file_path'
            $table->timestamps();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applied_leaves');
    }
};
