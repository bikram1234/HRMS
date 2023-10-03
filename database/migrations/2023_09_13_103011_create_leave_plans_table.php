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
        Schema::create('leave_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_id');
            $table->foreign('leave_id')->references('id')->on('leavetypes')->onDelete('cascade');
            $table->boolean('attachment_required')->default(false);
            $table->string('gender');
            $table->string('leave_year'); // Add leave_year column
            $table->string('credit_frequency'); // Add credit_frequency column
            $table->string('credit'); // Add credit column
            $table->boolean('include_public_holidays')->default(false); 
            $table->boolean('include_weekends')->default(false); 
            $table->boolean('can_be_clubbed_with_el')->default(false);
            $table->boolean('can_be_clubbed_with_cl')->default(false);
            $table->boolean('can_be_half_day')->default(false); 
            $table->boolean('probation_period')->default(false);
            $table->boolean('regular_period')->default(false);
            $table->boolean('contract_period')->default(false); 
            $table->boolean('notice_period')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_plans');
    }
};
