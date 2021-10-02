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

    public function scopeCreatedAt($query, $beginDate = null, $finalDate = null)
    {
        if (!$beginDate || !$finalDate){
            return $query;
        }
        return $query->whereBetween('created_at',[$beginDate, $finalDate]);
    }
}
