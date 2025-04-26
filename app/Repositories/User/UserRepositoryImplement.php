<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property User|mixed $model;
    */
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function createUser($data)

    {
       
        return $this->model->create($data);
    }

    public function findUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function deleteUser($id)
    {
        return $this->model->find($id)->delete();
    }


}
