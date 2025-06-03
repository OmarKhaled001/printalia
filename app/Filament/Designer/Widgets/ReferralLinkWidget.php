<?php

namespace App\Filament\Designer\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ReferralLinkWidget extends Widget
{
    protected static string $view = 'filament.designer.widgets.referral-link-widget';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::guard('designer')->check();
    }

    public function getReferralLink(): string
    {
        return url('/designer/register?ref=' . Auth::guard('designer')->user()?->referral_code);
    }

    public function getUserName(): string
    {
        return Auth::guard('designer')->user()?->name ?? '';
    }

    public function getReferralCount(): int
    {
        return  Auth::guard('designer')->user()->referrals()->count();
    }

    public function getPendingReferralEarnings(): float
    {
        return Auth::guard('designer')->user()->getPendingReferralEarnings();
    }


    public function getFinishedReferralEarnings(): float
    {
        return Auth::guard('designer')->user()->getFinishedReferralEarnings();
    }
}
