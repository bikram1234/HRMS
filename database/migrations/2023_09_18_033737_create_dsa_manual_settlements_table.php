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
        Schema::create('dsa_manual_settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dsa_settlement_id')->nullable(); // Make the dsa_settlement_id nullable
            $table->unsignedBigInteger('user_id')->nullable(); // Make the user_id nullable
            $table->date('from_date')->nullable(); 
            $table->string('from_location')->nullable(); 
            $table->date('to_date')->nullable(); 
            $table->string('to_location')->nullable(); 
            $table->integer('total_days')->nullable(); 
            $table->decimal('da', 10, 2)->nullable();
            $table->decimal('ta', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
            
             // Define the foreign key constraints
             // $table->foreign('dsa_settlement_id')
             // ->references('id')
             // ->on('dsa_settlements')
             // ->onDelete('cascade');

            $table->foreign('user_id')
             ->references('id')
             ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsa_manual_settlements');
    }
};
