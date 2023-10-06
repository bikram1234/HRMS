<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('designation');
            $table->string('department');
            $table->string('basic_pay');
            $table->string('transfer_claim_type');
            $table->string('current_location');
            $table->string('new_location');
            $table->string('claim_amount');
            $table->string('distance_km')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}