<?php

// app/Console/Commands/IncrementEarnedLeave.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LeaveBalance;

class IncrementEarnedLeave extends Command
{
    protected $signature = 'leave:increment-earned-leave';
    protected $description = 'Auto-increment earned leave for all users';

    public function handle()
    {
        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Implement logic to calculate and increment earned leave
            $earnedLeaveIncrement = 2.5; // Increment amount
            $earnedLeaveBalance = $user->leaveBalance->earned_leave_balance;
            echo "Earned Leave Balance: " . $earnedLeaveBalance;

            $newEarnedLeaveBalance = $earnedLeaveBalance + $earnedLeaveIncrement;

            // Update the leave balance
            LeaveBalance::updateOrCreate(
                ['user_id' => $user->id],
                ['earned_leave_balance' => $newEarnedLeaveBalance]
            );
        }

        $this->info('Earned leave has been incremented for all users.');
    }
}
