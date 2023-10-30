<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LeaveType;

class YearEndProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:year-end-process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    // Fetch all users who are eligible for year-end leave balance update
    $users = User::all();

    foreach ($users as $user) {
        $casualLeaveType = LeaveType::where('name', 'Casual Leave')->first();
        if ($casualLeaveType) {
            $defaultCasualLeaveBalance = $casualLeaveType->leaveRules->first()->duration;
        } else {
            $defaultCasualLeaveBalance = 0.0;
        }

        // Get the current casual_leave_balance
        $casualLeaveBalance = $user->leaveBalance->casual_leave_balance;

        // Increment the user's earned_leave balance by the casual_leave_balance
        $user->leaveBalance->increment('earned_leave_balance', $casualLeaveBalance);

        // Reset the casual_leave_balance to its default value
        $user->leaveBalance->casual_leave_balance = $defaultCasualLeaveBalance;
        $user->leaveBalance->save();
    }

    $this->info('Year-end leave balance processing completed.');
}

}
