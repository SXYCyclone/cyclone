<?php

namespace Src\Agenda\Company\Presentation\HTTP;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Agenda\Company\Application\DTO\CompanyData;
use Src\Agenda\Company\Application\Mappers\CompanyMapper;
use Src\Agenda\Company\Application\UseCases\Commands\DestroyCompanyCommand;
use Src\Agenda\Company\Application\UseCases\Commands\StoreCompanyCommand;
use Src\Agenda\Company\Application\UseCases\Commands\UpdateCompanyCommand;
use Src\Agenda\Company\Application\UseCases\Queries\FindAllCompaniesQuery;
use Src\Agenda\Company\Application\UseCases\Queries\FindCompanyByIdQuery;
use Symfony\Component\HttpFoundation\Response;

class CompanyController
{
    public function index(): JsonResponse
    {
        return response()->success((new FindAllCompaniesQuery())->handle());
    }

    public function show(int $id): JsonResponse
    {
        return response()->success((new FindCompanyByIdQuery($id))->handle());
    }

    public function store(Request $request): JsonResponse
    {
        $newCompany = CompanyMapper::fromRequest($request);
        $company = (new StoreCompanyCommand($newCompany))->execute();
        return response()->success($company, 'Company created successfully', Response::HTTP_CREATED);
    }

    public function update(int $company_id, Request $request): JsonResponse
    {
        $company = CompanyData::fromRequest($request, $company_id);
        (new UpdateCompanyCommand($company))->execute();
        return response()->success($company->toArray());
    }

    public function destroy(int $company_id, Request $request): JsonResponse
    {
        (new DestroyCompanyCommand($company_id))->execute();
        return response()->success(null, 'Company deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
