<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserRepository
{
    protected User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function store(array $data){
        return $this->model->create($data);
    }

    public function update(User $user, array $data){
        return $user->update($data);
    }
}