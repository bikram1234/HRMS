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
        Schema::create('leave_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_id');
            $table->foreign('leave_id')->references('id')->on('leavetypes')->onDelete('cascade');
            $table->unsignedBigInteger('grade_id');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->integer('duration');
            $table->string('uom');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('islossofpay')->default(false);
            $table->string('employee_type');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_rules');
    }
};
