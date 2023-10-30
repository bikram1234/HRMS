<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LeaveType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $casualLeaveType = LeaveType::where('name', 'Casual Leave')->first();

        Schema::create('leave_balances', function (Blueprint $table) use ($casualLeaveType) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('earned_leave_balance', 10, 2)->default(0.0);

            if ($casualLeaveType) {
                $defaultCasualLeaveBalance = $casualLeaveType->leaveRules->first()->duration;
            } else {
                $defaultCasualLeaveBalance = 0.0;
            }

            $table->decimal('casual_leave_balance', 10, 2)->default($defaultCasualLeaveBalance);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
