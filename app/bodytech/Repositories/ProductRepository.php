<?php

namespace App\bodytech\Repositories;

use App\Base\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function getModel(): Product
    {
        return new Product;
    }

}
