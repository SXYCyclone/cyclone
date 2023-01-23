<?php

namespace Src\Agenda\Company\Domain\Services;

use Src\Agenda\Company\Domain\Model\Company;
use Src\Agenda\Company\Domain\Repositories\CompanyRepositoryInterface;

/**
 * This service is responsible for the identification of the company using multiple strategies.
 * Strategies include:
 * - Domain
 * - Subdomain
 * - Path
 * - Environment (for testing purposes)
 */
class CompanyIdentificationService
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
    ) {
    }

    public function identifyByEnvironment(): ?Company
    {
        return $this->companyRepository->findById('1');
    }
}
