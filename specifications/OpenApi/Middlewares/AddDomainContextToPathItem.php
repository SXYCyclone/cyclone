<?php

namespace Specifications\OpenApi\Middlewares;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use Illuminate\Support\Str;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\RouteInformation;

class AddDomainContextToPathItem implements \Vyuldashev\LaravelOpenApi\Contracts\PathMiddleware
{
    public function before(RouteInformation $routeInformation): void
    {
        $fqcn = Str::of($routeInformation->controller)
            ->after('Src\\')
            ->before('Presentation\\')
            ->toString();
        $segments = explode('\\', $fqcn);
        [$boundedContext, $domain] = $segments;
        if (empty($domain)) {
            $domain = $boundedContext;
            unset($boundedContext);
        }

        foreach ($routeInformation->actionAttributes as $attribute) {
            if ($attribute instanceof Operation) {
                $attribute->tags[] = "domain:{$domain}";
                if (isset($boundedContext)) {
                    $attribute->tags[] = "context:{$boundedContext}";
                }
            }
        }
    }

    public function after(PathItem $pathItem): PathItem
    {
        return $pathItem;
    }
}
