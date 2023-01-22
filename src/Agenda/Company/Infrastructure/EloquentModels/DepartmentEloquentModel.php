<?php

namespace Src\Agenda\Company\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Src\Agenda\Company\Infrastructure\EloquentModels\DepartmentEloquentModel
 *
 * @property int $id
 * @property int $company_id
 * @property int $address_id
 * @property string $name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Src\Agenda\Company\Infrastructure\EloquentModels\AddressEloquentModel $address
 * @property-read \Src\Agenda\Company\Infrastructure\EloquentModels\CompanyEloquentModel $company
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentEloquentModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DepartmentEloquentModel extends Model
{
    protected $table = 'company_departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'address_id',
        'name',
        'is_active'
    ];

    public array $rules = [
        'company_id' => 'required|integer',
        'address_id' => 'nullable|integer',
        'name' => 'required|string',
        'is_active' => 'required|boolean'
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
        'is_active' => 'boolean'
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
