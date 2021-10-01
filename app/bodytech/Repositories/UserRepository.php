<?php

namespace App\bodytech\Repositories;

use App\Base\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel(): User
    {
        return new User;
    }

}
