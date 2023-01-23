<?php

namespace Src\Agenda\Company\Infrastructure\LaravelEvents;

use Src\Agenda\Company\Domain\Services\CompanyIdentificationService;
use Tenancy\Identification\Events\Resolving;

class TenantResolvingListener
{
    public function handle(Resolving $event)
    {
        return app(CompanyIdentificationService::class)->identifyByEnvironment();
    }
}
