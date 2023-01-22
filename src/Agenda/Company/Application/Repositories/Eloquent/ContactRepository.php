<?php

namespace Src\Agenda\Company\Application\Repositories\Eloquent;

use Src\Agenda\Company\Application\Mappers\ContactMapper;
use Src\Agenda\Company\Domain\Model\Company;
use Src\Agenda\Company\Domain\Model\Entities\Contact;
use Src\Agenda\Company\Domain\Repositories\ContactRepositoryInterface;
use Src\Agenda\Company\Infrastructure\EloquentModels\ContactEloquentModel;

class ContactRepository implements ContactRepositoryInterface
{
    public function upsertAll(Company $company): Contact
    {
        foreach ($company->contacts as $contact) {
            $contactEloquent = ContactMapper::toEloquent($contact);
            $contactEloquent->company_id = $company->id;
            $contactEloquent->save();
        }
        /** @phpstan-ignore-next-line Waiting for upstream reply */
        return ContactMapper::fromEloquent($contactEloquent);
    }
    public function remove(int $contact_id): void
    {
        $contactEloquent = ContactEloquentModel::query()->findOrFail($contact_id);
        $contactEloquent->delete();
    }
}
