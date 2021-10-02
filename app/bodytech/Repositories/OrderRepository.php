<?php

namespace App\bodytech\Repositories;

use App\Base\BaseRepository;
use App\Models\Order;
use Carbon\Carbon;

class OrderRepository extends BaseRepository
{
    public function getModel(): Order
    {
        return new Order;
    }

    public function getBetweenDate($beginDate = null, $finalDate = null)
    {
        if ($beginDate && $finalDate){
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $finalDate = Carbon::parse($finalDate)->endOfDay();
        }
        return $this->getModel()->createdAt($beginDate, $finalDate)->get();

    }
}
