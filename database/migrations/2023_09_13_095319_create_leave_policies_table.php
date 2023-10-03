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
        Schema::create('leave_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_id');
            $table->foreign('leave_id')->references('id')->on('leavetypes')->onDelete('cascade');
            $table->string('policy_name');
            $table->string('policy_description');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status')->default(true);
            $table->boolean('is_information_only')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_policies');
    }
};
