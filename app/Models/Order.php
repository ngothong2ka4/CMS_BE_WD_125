<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = [
        'id_user',
        'email',
        'recipient_name',
        'phone_number',
        'recipient_address',
        'order_date',
        'payment_role',
        'status_payment',
        'status',
        'total_payment'
    ];

    public function orderDetail(){
        return $this->hasOne(OrderDetail::class,'id','id_order');
    }
}
