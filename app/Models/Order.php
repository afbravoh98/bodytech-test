<?php

namespace App\Models;

use App\bodytech\Relations\OrderRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use OrderRelations;

    protected $fillable = [
        'user_id',
        'status',
        'total',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];
}
