<?php

namespace App\bodytech\Repositories;

use App\Base\BaseRepository;
use App\Models\Order;

class OrderRepository extends BaseRepository
{
    public function getModel(): Order
    {
        return new Order;
    }
}
