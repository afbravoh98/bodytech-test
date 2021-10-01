<?php

namespace App\bodytech\Storage;

use App\Models\ShoppingCart;
use Darryldecode\Cart\CartCollection;

class CartStorage {

    public function has($key)
    {
        return ShoppingCart::find($key);
    }

    public function get($key)
    {
        if($this->has($key))
        {
            return new CartCollection(ShoppingCart::find($key)->cart_data);
        }
        else
        {
            return [];
        }
    }

    public function put($key, $value)
    {
        if($row = ShoppingCart::find($key))
        {
            // update
            $row->cart_data = $value;
            $row->save();
        }
        else
        {
            ShoppingCart::create([
                'id' => $key,
                'cart_data' => $value
            ]);
        }
    }
}
