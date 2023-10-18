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
        Schema::create('approval_rules', function (Blueprint $table) {
            $table->id();
            $table->string('For');
            $table->string('RuleName');
            $table->unsignedBigInteger('type_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status');
            $table->timestamps();

            // $table->foreign('type_id')
            // ->references('id')
            // ->on('leavetypes')
            // ->onDelete('cascade')
            // ->when(fn ($query) => $query->where('For', 'Leave')); // Conditional foreign key for Leave

            $table->foreign('type_id')
                ->references('id')
                ->on('expense_types')
                ->onDelete('cascade')
                ->when(fn ($query) => $query->where('For', 'Expense')); // Conditional foreign key for Expense
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_rules');
    }
};
