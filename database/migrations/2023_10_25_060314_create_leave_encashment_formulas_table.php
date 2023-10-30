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
        Schema::create('leave_encashment_formulas', function (Blueprint $table) {
            $table->id();
            $table->string('condition')->nullable();
            $table->string('field');
            $table->string('operator');
            $table->integer('value')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('encashment_condition_id')->nullable();
            $table->timestamps();

            $table->foreign('encashment_condition_id')->references('id')->on('leave_encashment_approval_conditions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_encashment_formulas');
    }
};
