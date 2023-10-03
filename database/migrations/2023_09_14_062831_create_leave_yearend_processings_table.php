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
        Schema::create('leave_yearend_processings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_id');
            $table->foreign('leave_id')->references('id')->on('leavetypes')->onDelete('cascade');
            $table->boolean('allow_carryover')->default(false);
            $table->integer('carryover_limit')->default(0);
            $table->boolean('payat_yearend')->default(false);
            $table->integer('min_balance')->default(0);
            $table->integer('max_balance')->default(0);
            $table->boolean('carryforward_toEL')->default(false);
            $table->integer('carryforward_toEL_limit')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_yearend_processings');
    }
};
