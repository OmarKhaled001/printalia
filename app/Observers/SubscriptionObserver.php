<?php


namespace App\Observers;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionObserver
{
    public function updated(Subscription $subscription)
    {
        $designer = $subscription->subscribable;

        if ($subscription->is_approved && $subscription->end_date >= Carbon::now()) {
            $designer->has_active_subscription = true;
            $designer->save();
        }

        if (!$subscription->is_approved || $subscription->end_date < Carbon::now()) {
            $designer->has_active_subscription = false;
            $designer->save();
        }
    }
}
