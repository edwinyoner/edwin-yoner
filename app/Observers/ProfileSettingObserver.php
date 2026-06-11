<?php

namespace App\Observers;

use App\Models\ProfileSetting;
use Illuminate\Support\Facades\Cache;

class ProfileSettingObserver
{
    /**
     * Handle the ProfileSetting "updated" event.
     */
    public function updated(ProfileSetting $profileSetting): void
    {
        Cache::forget('profile_settings');
        Cache::forget('profile_data');
        Cache::forget('home_profile');
    }

    /**
     * Handle the ProfileSetting "created" event.
     */
    public function created(ProfileSetting $profileSetting): void
    {
        Cache::forget('profile_settings');
        Cache::forget('profile_data');
        Cache::forget('home_profile');
    }

    /**
     * Handle the ProfileSetting "deleted" event.
     */
    public function deleted(ProfileSetting $profileSetting): void
    {
        Cache::forget('profile_settings');
        Cache::forget('profile_data');
        Cache::forget('home_profile');
    }
}