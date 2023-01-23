<?php

namespace Src\Agenda\Company\Presentation\HTTP;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Agenda\Company\Application\Mappers\DepartmentMapper;
use Src\Agenda\Company\Application\UseCases\Commands\PersistDepartmentsCommand;
use Src\Agenda\Company\Application\UseCases\Commands\RemoveDepartmentCommand;
use Src\Agenda\Company\Application\UseCases\Queries\FindCompanyByIdQuery;
use Symfony\Component\HttpFoundation\Response;

class CompanyDepartmentController
{
    public function add(int $company_id, Request $request): JsonResponse
    {
        $company = (new FindCompanyByIdQuery($company_id))->handle();

        $department = DepartmentMapper::fromRequest($request);
        $company->addDepartment($department);
        $departmentData = (new PersistDepartmentsCommand($company))->execute();
        return response()->success($departmentData->toArray());
    }

    public function update(int $company_id, int $department_id, Request $request): JsonResponse
    {
        $company = (new FindCompanyByIdQuery($company_id))->handle();

        $department = DepartmentMapper::fromRequest($request, $department_id);
        $company->updateDepartment($department);
        (new PersistDepartmentsCommand($company))->execute();
        return response()->success($department->toArray());
    }

    public function remove(int $company_id, int $department_id): JsonResponse
    {
        $company = (new FindCompanyByIdQuery($company_id))->handle();
        $company->removeDepartment($department_id);
        (new RemoveDepartmentCommand($department_id))->execute();
        return response()->success(null, 'Department deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
