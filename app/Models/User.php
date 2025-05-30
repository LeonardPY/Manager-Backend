<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use App\Models\Traits\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property int $user_role_id
 * @property int $country_id
 * @property int $status
 * @property string $logo
 * @property Category $category
 * @property Country $country
 * @property Worker $worker
*/
class User extends Authenticatable implements  MustVerifyEmail
{
    use HasFactory, Notifiable, Filterable, HasApiTokens;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'user_role_id',
        'country_id',
        'status',
        'logo',
    ];

    /** @var array<int, string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_role_id' => UserRoleEnum::class
        ];
    }

    /** @return bool */
    public function isAdmin(): bool
    {
        return $this->user_role_id == UserRoleEnum::ADMIN;
    }

    /** @return BelongsTo */
    public function country(): BelongsTo
    {
        return $this->BelongsTo(Country::class, 'country_id', 'id');
    }

    /** @return HasMany */
    public function category(): HasMany
    {
        return $this->hasMany(Category::class, 'user_id', 'id');
    }

    /** @return HasMany */
    public function address(): HasMany
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    /** @return HasOne */
    public function worker(): hasOne
    {
        return $this->hasOne(Worker::class, 'user_id', 'id');
    }
}
