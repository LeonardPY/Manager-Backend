<?php

namespace App\Models;

use App\Http\Filters\FilterTraits\FilterHasPagination;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $picture
 * @property float $salary
 * @property int $role_id
 * @property int $user_id
 * @property int $organization_id
*/
class Worker extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'email',
        'picture',
        'salary',
        'role_id',
        'user_id',
        'organization_id'
    ];
}
