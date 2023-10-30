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
        Schema::create('no_due_request_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('no_due_request_id'); // Foreign key to link to the request
            $table->unsignedBigInteger('user_id'); // Foreign key for the user providing the approval
            $table->enum('status', ['approved', 'declined', 'pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('no_due_request_approvals');
    }
};
