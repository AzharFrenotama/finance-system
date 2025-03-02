<?php

namespace App\Observers;

use App\Models\Income;
use App\Models\Profile;

class IncomeObserver
{
    /**
     * Handle the Income "created" event.
     */
    public function created(Income $income): void
    {
        $profiles = Profile::find($income->profile_id);
        if ($profiles) {
            $profiles->balance += $income->amount;
            $profiles->save();
        }
    }

    /**
     * Handle the Income "updated" event.
     */
    public function updated(Income $income): void
    {
        //
    }

    /**
     * Handle the Income "deleted" event.
     */
    public function deleted(Income $income): void
    {
        $profiles = Profile::find($income->profile_id);
        if ($profiles) {
            $profiles->balance -= $income->amount;
            $profiles->save();
        }
    }

    /**
     * Handle the Income "restored" event.
     */
    public function restored(Income $income): void
    {
        //
    }

    /**
     * Handle the Income "force deleted" event.
     */
    public function forceDeleted(Income $income): void
    {
        //
    }
}
