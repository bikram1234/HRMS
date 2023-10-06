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
        Schema::create('expense_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('expense_type_id')->constrained();
            $table->date('application_date');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->enum('status', ['pending', 'approved','rejected'])->default('pending'); // Add the status field
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_applications');
    }
};
