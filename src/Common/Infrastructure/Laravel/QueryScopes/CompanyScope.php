<?php

namespace Src\Common\Infrastructure\Laravel\QueryScopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;
use Tenancy\Facades\Tenancy;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $tenant = Tenancy::getTenant();
        if (!$tenant) {
            Log::error('Tenant not found in CompanyScope, may led to unexpected results');
            return;
        }
        $builder->where($tenant->getTenantKeyName(), $tenant->getTenantKey());
    }
}
