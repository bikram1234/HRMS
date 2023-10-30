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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable();

            // Define the foreign key constraint
            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('set null'); // You can choose the desired action on delete

            // You may also want to create an index for the foreign key column
            $table->index('region_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            
            // Drop the region_id column
            $table->dropColumn('region_id');
        });
    }
};
