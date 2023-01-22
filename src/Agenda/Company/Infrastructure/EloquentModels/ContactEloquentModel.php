<?php

namespace Src\Agenda\Company\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Src\Agenda\Company\Infrastructure\EloquentModels\ContactEloquentModel
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $address_id
 * @property string $name
 * @property string $contact_role
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Src\Agenda\Company\Infrastructure\EloquentModels\AddressEloquentModel|null $address
 * @property-read \Src\Agenda\Company\Infrastructure\EloquentModels\CompanyEloquentModel $company
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereContactRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactEloquentModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactEloquentModel extends Model
{
    protected $table = 'company_contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'contact_role',
        'email',
        'phone',
        'address_id',
    ];

    public array $rules = [
        'company_id' => 'required|integer',
        'address_id' => 'nullable|integer',
        'name' => 'required|string',
        'contact_role' => 'required|string',
        'email' => 'required|string',
        'phone' => 'required|string'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'company_id' => 'integer',
        'address_id' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(CompanyEloquentModel::class);
    }

    public function address()
    {
        return $this->belongsTo(AddressEloquentModel::class);
    }
}
