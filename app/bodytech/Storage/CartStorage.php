<?php

namespace App\bodytech\Storage;

use App\Models\ShoopingCart;
use Darryldecode\Cart\CartCollection;

class CartStorage {

    public function has($key)
    {
        return ShoopingCart::find($key);
    }

    public function get($key)
    {
        if($this->has($key))
        {
            return new CartCollection(ShoopingCart::find($key)->cart_data);
        }
        else
        {
            return [];
        }
    }

    public function put($key, $value)
    {
        if($row = ShoopingCart::find($key))
        {
            // update
            $row->cart_data = $value;
            $row->save();
        }
        else
        {
            ShoopingCart::create([
                'id' => $key,
                'cart_data' => $value
            ]);
        }
    }
}
