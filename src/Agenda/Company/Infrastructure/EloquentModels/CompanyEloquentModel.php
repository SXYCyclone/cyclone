<?php

namespace Src\Agenda\Company\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Src\Agenda\Company\Infrastructure\EloquentModels\CompanyEloquentModel
 *
 * @property int                                                                                                                       $id
 * @property string                                                                                                                    $fiscal_name
 * @property string                                                                                                                    $social_name
 * @property string                                                                                                                    $vat
 * @property bool                                                                                                                      $is_active
 * @property \Illuminate\Support\Carbon|null                                                                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Src\Agenda\Company\Infrastructure\EloquentModels\AddressEloquentModel[]    $addresses
 * @property-read int|null                                                                                                             $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Src\Agenda\Company\Infrastructure\EloquentModels\ContactEloquentModel[]    $contacts
 * @property-read int|null                                                                                                             $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Src\Agenda\Company\Infrastructure\EloquentModels\DepartmentEloquentModel[] $departments
 * @property-read int|null                                                                                                             $departments_count
 * @property-read mixed                                                                                                                $main_address
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel whereFiscalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel whereSocialName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyEloquentModel whereVat($value)
 * @mixin \Eloquent
 */
class CompanyEloquentModel extends Model
{
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fiscal_name',
        'social_name',
        'vat',
        'is_active',
    ];

    public array $rules = [
        'fiscal_name' => 'required|string|max:255',
        'social_name' => 'required|string|max:255',
        'vat' => 'required|string|max:255',
        'is_active' => 'required|boolean',
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
        'is_active' => 'boolean',
    ];

    protected $with = ['addresses'];

    public function addresses()
    {
        return $this->hasMany(AddressEloquentModel::class, 'company_id');
    }

    public function departments()
    {
        return $this->hasMany(DepartmentEloquentModel::class, 'company_id');
    }

    public function contacts()
    {
        return $this->hasMany(ContactEloquentModel::class, 'company_id');
    }

    public function getMainAddressAttribute()
    {
        return $this->addresses()->where('type', 'fiscal')->first();
    }
}
