<?php

namespace Src\Agenda\Company\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Src\Agenda\Company\Infrastructure\EloquentModels\AddressEloquentModel
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $type
 * @property string $street
 * @property string $zip_code
 * @property string $city
 * @property string $country
 * @property string|null $phone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Src\Agenda\Company\Infrastructure\EloquentModels\CompanyEloquentModel $company
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressEloquentModel whereZipCode($value)
 * @mixin \Eloquent
 */
class AddressEloquentModel extends Model
{
    protected $table = 'company_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'type',
        'street',
        'zip_code',
        'city',
        'country',
        'phone',
        'email',
    ];

    public array $rules = [
        'company_id' => 'required|integer',
        'name' => 'required|string',
        'type' => 'required|in:fiscal,logistic,administrative',
        'street' => 'required|string',
        'zip_code' => 'required|string',
        'city' => 'required|string',
        'country' => 'required|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
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
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyEloquentModel::class);
    }
}
