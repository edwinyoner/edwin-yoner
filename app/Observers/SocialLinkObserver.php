<?php

namespace App\Observers;

use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;

class SocialLinkObserver
{
    /**
     * Handle the SocialLink "created" event.
     */
    public function created(SocialLink $socialLink): void
    {
        Cache::forget('social_links_active');
    }

    /**
     * Handle the SocialLink "updated" event.
     */
    public function updated(SocialLink $socialLink): void
    {
        Cache::forget('social_links_active');
    }

    /**
     * Handle the SocialLink "deleted" event.
     */
    public function deleted(SocialLink $socialLink): void
    {
        Cache::forget('social_links_active');
    }

    /**
     * Handle the SocialLink "restored" event.
     */
    public function restored(SocialLink $socialLink): void
    {
        Cache::forget('social_links_active');
    }
}