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
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_definition_id'); // Define the rate_definition_id column
            $table->unsignedBigInteger('grade');
            $table->string('region');
            $table->decimal('limit_amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->foreign('grade')->references('id')
                  ->on('grades')
                  ->onDelete('cascade');
            $table->foreign('rate_definition_id') // Define the foreign key constraint
                ->references('id')
                ->on('rate_definitions')
                ->onDelete('cascade'); // This enables cascade deletion
            $table->foreignId('policy_id')
                ->constrained('policies')
                ->onDelete('cascade'); // This enables cascade deletion
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
    }
};
