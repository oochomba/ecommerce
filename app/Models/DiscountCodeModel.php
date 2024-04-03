<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCodeModel extends Model
{
    use HasFactory;
    protected $table = 'discount_code';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'percent_amount',
        'expire_date',
        'status',
        'is_delete',
        'created_by',
    ];
    static public function checkDiscount($discount_code)
    {
        return self::select('discount_code.*')
            ->where([
                'discount_code.name' => $discount_code,
                'discount_code.is_delete' => 0,
                'discount_code.status' => 0
            ])
            ->where('discount_code.expire_date', '>=', date('Y-m-d'))
            ->get()
            ->first();
    }
}
