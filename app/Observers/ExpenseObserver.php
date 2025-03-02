<?php

namespace App\Observers;

use App\Models\Expenses;
use App\Models\Profile;

class ExpenseObserver
{
    /**
     * Handle the Expenses "created" event.
     */
    public function created(Expenses $expenses): void
    {
        $profiles = Profile::find($expenses->profile_id);
        if ($profiles) {
            $profiles->balance -= $expenses->amount;
            $profiles->save();
        }
    }

    /**
     * Handle the Expenses "updated" event.
     */
    public function updated(Expenses $expenses): void
    {
        //
    }

    /**
     * Handle the Expenses "deleted" event.
     */
    public function deleted(Expenses $expenses): void
    {
        $profiles = Profile::find($expenses->profile_id);
        if ($profiles) {
            $profiles->balance += $expenses->amount;
            $profiles->save();
        }
    }

    /**
     * Handle the Expenses "restored" event.
     */
    public function restored(Expenses $expenses): void
    {
        //
    }

    /**
     * Handle the Expenses "force deleted" event.
     */
    public function forceDeleted(Expenses $expenses): void
    {
        //
    }
}
