<?php

namespace App\Repositories\Eloquent;

use App\Models\ResetPassword;
use App\Repositories\ResetPasswordRepositoryInterface;

final class ResetPasswordRepository extends BaseRepository implements ResetPasswordRepositoryInterface
{
    public function __construct(ResetPassword $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
}
