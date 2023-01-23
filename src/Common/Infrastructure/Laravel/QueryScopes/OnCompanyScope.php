<?php

namespace Src\Common\Infrastructure\Laravel\QueryScopes;

trait OnCompanyScope
{
    protected static function booted()
    {
        self::addGlobalScope(new CompanyScope());
    }
}
