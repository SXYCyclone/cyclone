<?php

namespace Src\Common\Infrastructure\Laravel\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Src\Agenda\Company\Infrastructure\LaravelEvents\TenantConnectionConfiguringListener;
use Src\Agenda\Company\Infrastructure\LaravelEvents\TenantConnectionResolvingListener;
use Src\Agenda\Company\Infrastructure\LaravelEvents\TenantResolvingListener;
use Tenancy\Affects\Connections\Events\Drivers\Configuring;
use Tenancy\Affects\Connections\Events\Resolving;

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
        Resolving::class => [TenantConnectionResolvingListener::class],
        Configuring::class => [TenantConnectionConfiguringListener::class],
        \Tenancy\Identification\Events\Resolving::class => [TenantResolvingListener::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
