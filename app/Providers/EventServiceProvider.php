<?php

namespace App\Providers;

use App\Models\SocialLink;
use App\Observers\SocialLinkObserver;
use App\Models\ProfileSetting;
use App\Observers\ProfileSettingObserver;
use App\Models\PortfolioSetting;
use App\Observers\PortfolioSettingObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        SocialLink::observe(SocialLinkObserver::class);
        ProfileSetting::observe(ProfileSettingObserver::class);
        PortfolioSetting::observe(PortfolioSettingObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}