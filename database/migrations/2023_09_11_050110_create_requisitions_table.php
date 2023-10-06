<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('requisitions', function (Blueprint $table) {
        $table->id();
        $table->string('requisition_no')->unique();
        $table->string('requisition_type');
        $table->date('requisition_date'); // data type date
        $table->date('need_by_date'); // data type date
        $table->string('employee_name');
        $table->string('item_category');
        $table->string('item_no');
        $table->string('description');
        $table->string('specification');
        $table->string('remarks');
        $table->string('uom');
        $table->string('required_qty');
        $table->string('file_path')->nullable(); //file_path column
        $table->timestamps();
    });
    
    // Set the initial ID sequence value for requisition numbers
    //DB::statement("ALTER TABLE requisitions AUTO_INCREMENT = 1000");
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
}
