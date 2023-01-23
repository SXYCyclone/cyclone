<?php

namespace Src\Agenda\Company\Infrastructure\LaravelEvents;

use Tenancy\Affects\Connections\Events\Drivers\Configuring;

class TenantConnectionConfiguringListener
{
    public function handle(Configuring $event)
    {
    }
}
