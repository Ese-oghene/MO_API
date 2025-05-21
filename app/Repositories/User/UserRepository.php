<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;


interface UserRepository extends Repository{

    public function createUser($data);
    public function findUserByEmail($email);
    public function deleteUser($id);

}
