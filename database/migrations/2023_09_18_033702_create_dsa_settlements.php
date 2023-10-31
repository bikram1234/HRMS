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
         // Get the ID of the 'DSA Settlement' expense type
         $expenseType = DB::table('expense_types')->where('name', 'DSA Settlement')->first();

         // Check if the expense type exists
         if ($expenseType) {
             $expenseTypeId = $expenseType->id;

                Schema::create('dsa_settlements', function (Blueprint $table)use ($expenseTypeId) {
                    $table->id();
                    $table->unsignedBigInteger('user_id');
                    $table->unsignedBigInteger('advance_application_id')->nullable(); // Make it nullable
                    $table->string('advance_no')->nullable();
                    $table->decimal('advance_amount', 10, 2)->default(0);
                    $table->decimal('total_amount_adjusted', 10, 2)->nullable(); // Make it nullable
                    $table->decimal('net_payable_amount', 10, 2)->nullable(); // Make it nullable
                    $table->decimal('balance_amount', 10, 2)->nullable(); // Make it nullable
                    $table->string('upload_file')->nullable();
                    $table->enum('level1', ['pending', 'approved','rejected'])->default('pending'); 
                    $table->enum('level2', ['pending', 'approved','rejected'])->default('pending'); 
                    $table->enum('level3', ['pending', 'approved','rejected'])->default('pending');
                    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                    $table->text('remark')->nullable();
                    $table->unsignedBigInteger('expensetype_id')->default($expenseTypeId);
                    $table->date('creation_date');
                    $table->timestamps();

                    // Define foreign key constraints for other fields, if needed
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    $table->foreign('expensetype_id')->references('id')->on('expense_types')->onDelete('cascade');
                });
    } else {
        // Handle the case where the expense type does not exist
        echo "Expense type 'DSA Settlement' not found.";
    
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsa_settlements');
    }
};