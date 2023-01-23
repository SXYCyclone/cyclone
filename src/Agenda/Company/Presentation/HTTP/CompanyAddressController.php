<?php

namespace Src\Agenda\Company\Presentation\HTTP;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Agenda\Company\Application\Mappers\AddressMapper;
use Src\Agenda\Company\Application\UseCases\Commands\PersistAddressesCommand;
use Src\Agenda\Company\Application\UseCases\Commands\RemoveAddressCommand;
use Src\Agenda\Company\Application\UseCases\Queries\FindCompanyByIdQuery;
use Symfony\Component\HttpFoundation\Response;

class CompanyAddressController
{
    public function add(int $company_id, Request $request): JsonResponse
    {
        $company = (new FindCompanyByIdQuery($company_id))->handle();

        $address = AddressMapper::fromRequest($request);
        $company->addAddress($address);
        $addressData = (new PersistAddressesCommand($company))->execute();
        return response()->success($addressData->toArray());
    }

    public function update(int $company_id, int $address_id, Request $request): JsonResponse
    {
        $company = (new FindCompanyByIdQuery($company_id))->handle();

        $address = AddressMapper::fromRequest($request, $address_id);
        $company->updateAddress($address);
        (new PersistAddressesCommand($company))->execute();
        return response()->success($address->toArray());
    }

    public function remove(int $company_id, int $address_id): JsonResponse
    {
        $company = (new FindCompanyByIdQuery($company_id))->handle();
        $company->removeAddress($address_id);
        (new RemoveAddressCommand($address_id))->execute();
        return response()->success(null, 'Address deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
