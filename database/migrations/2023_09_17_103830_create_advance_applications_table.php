<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('advance_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('advance_type_id');
            $table->string('advance_no')->unique();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->string('mode_of_travel')->nullable();
            $table->string('from_location')->nullable();
            $table->string('to_location')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->text('purpose')->nullable();
            $table->string('upload_file')->nullable();
            $table->integer('emi_count')->nullable();
            $table->date('deduction_period')->nullable();
            $table->decimal('interest_rate', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('monthly_emi_amount', 10, 2)->nullable();
            $table->string('item_type')->nullable();
            $table->enum('level1', ['pending', 'approved','rejected'])->default('pending'); 
            $table->enum('level2', ['pending', 'approved','rejected'])->default('pending'); 
            $table->enum('level3', ['pending', 'approved','rejected'])->default('pending');
            $table->enum('status', ['pending', 'approved','rejected'])->default('pending'); // Add the status field
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advance_type_id')->references('id')->on('advances')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('advance_applications');
    }
}
