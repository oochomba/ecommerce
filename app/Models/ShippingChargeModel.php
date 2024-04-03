<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingChargeModel extends Model
{
    use HasFactory;
    protected $table = 'shipping_charge';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'status',
        'is_delete',
        'created_by',
    ];
    static public function checkShipping()
    {
        return self::select('shipping_charge.*')
            ->where([
                'shipping_charge.is_delete' => 0,
                'shipping_charge.status' => 0
            ])
            ->orderBy('shipping_charge.id', 'ASC')
            ->get();
    }
    static public function getSingle($id){
        return self::find($id);
    }
}
