<?php

namespace Src\Agenda\Company\Infrastructure\LaravelEvents;

use Tenancy\Affects\Connections\Contracts\ProvidesConfiguration;
use Tenancy\Affects\Connections\Events\Drivers\Configuring;
use Tenancy\Affects\Connections\Events\Resolving;
use Tenancy\Identification\Contracts\Tenant;

class TenantConnectionResolvingListener implements ProvidesConfiguration
{
    public function handle(Resolving $event)
    {
        return $this;
    }

    public function configure(Tenant $tenant): array
    {
        $config = [];

        event(new Configuring($tenant, $config, $this));

        return $config;
    }
}
