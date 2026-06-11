<?php

namespace App\Observers;

use App\Models\PortfolioSetting;
use Illuminate\Support\Facades\Cache;

class PortfolioSettingObserver
{
    /**
     * Handle the PortfolioSetting "updated" event.
     */
    public function updated(PortfolioSetting $portfolioSetting): void
    {
        Cache::forget('portfolio_settings');
        Cache::forget('portfolio_colors');
    }

    /**
     * Handle the PortfolioSetting "created" event.
     */
    public function created(PortfolioSetting $portfolioSetting): void
    {
        Cache::forget('portfolio_settings');
        Cache::forget('portfolio_colors');
    }

    /**
     * Handle the PortfolioSetting "deleted" event.
     */
    public function deleted(PortfolioSetting $portfolioSetting): void
    {
        Cache::forget('portfolio_settings');
        Cache::forget('portfolio_colors');
    }
}