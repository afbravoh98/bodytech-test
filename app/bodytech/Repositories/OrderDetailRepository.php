<?php

namespace App\bodytech\Repositories;

use App\Base\BaseRepository;
use App\Models\OrderDetail;

class OrderDetailRepository extends BaseRepository
{
    public function getModel(): OrderDetail
    {
        return new OrderDetail;
    }

}
