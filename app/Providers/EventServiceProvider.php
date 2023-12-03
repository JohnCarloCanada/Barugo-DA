<?php

namespace App\Providers;

use App\Events\ClaimedSuccesful;
use App\Events\HandleError;
use App\Events\HandleUser;
use App\Listeners\ChangedStatusClaimedStatusToTrue;
use App\Listeners\CreateIssuanceHistory;
use App\Listeners\HandleUserLogout;
use App\Listeners\SendSomeError;
use App\Listeners\UpdateInventoryAfterClaiming;
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
        HandleUser::class => [
            HandleUserLogout::class,
        ],
        ClaimedSuccesful::class => [
            UpdateInventoryAfterClaiming::class,
            ChangedStatusClaimedStatusToTrue::class,
            CreateIssuanceHistory::class
        ],
        HandleError::class => [
            SendSomeError::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
