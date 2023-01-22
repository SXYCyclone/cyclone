<?php

namespace Src\Agenda\Company\Application\UseCases\Commands;

use Src\Agenda\Company\Domain\Model\Company;
use Src\Agenda\Company\Domain\Model\Entities\Address;
use Src\Agenda\Company\Domain\Policies\CompanyPolicy;
use Src\Agenda\Company\Domain\Repositories\AddressRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class PersistAddressesCommand implements CommandInterface
{
    private AddressRepositoryInterface $repository;

    public function __construct(
        private readonly Company $company
    ) {
        $this->repository = app()->make(AddressRepositoryInterface::class);
    }

    public function execute(): Address
    {
        authorize('persistAddresses', CompanyPolicy::class);
        return $this->repository->upsertAll($this->company);
    }
}
