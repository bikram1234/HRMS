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
        Schema::create('advance_approval_rules', function (Blueprint $table) {
            $table->id();
            $table->string('For');
            $table->string('RuleName');
            $table->unsignedBigInteger('type_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('type_id')
                ->references('id')
                ->on('advances')
                ->onDelete('cascade')
                ->when(fn ($query) => $query->where('For', 'Loan')); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_approval_rules');
    }
};
