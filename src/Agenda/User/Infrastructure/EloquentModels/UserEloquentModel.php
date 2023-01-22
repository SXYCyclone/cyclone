<?php

namespace Src\Agenda\User\Infrastructure\EloquentModels;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Src\Agenda\User\Infrastructure\EloquentModels\Casts\PasswordCast;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Src\Agenda\User\Infrastructure\EloquentModels\UserEloquentModel
 *
 * @property int $id
 * @property string $name
 * @property int|null $company_id
 * @property string|null $avatar
 * @property string $email
 * @property $password
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property bool $is_admin
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEloquentModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserEloquentModel extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'company_id',
        'avatar',
        'password',
        'is_admin',
        'is_active'
    ];

    public array $rules = [
        'name' => 'required',
        'email' => 'required',
        'company_id' => 'nullable',
        'avatar' => 'nullable',
        'password' => 'confirmed|min:8|nullable',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'avatar' => 'string',
        'password' => PasswordCast::class
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
