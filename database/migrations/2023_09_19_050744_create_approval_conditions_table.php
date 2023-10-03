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
        Schema::create('approval_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approval_rule_id');
            $table->enum('approval_type', ['Hierarchy', 'Single User', 'Auto Approval']);
            $table->unsignedBigInteger('hierarchy_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('MaxLevel')->nullable();
            $table->boolean('AutoApproval')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('approval_rule_id')->references('id')->on('approval_rules')->onDelete('cascade');
            $table->foreign('hierarchy_id')->references('id')->on('hierarchies')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_conditions');
    }
};
