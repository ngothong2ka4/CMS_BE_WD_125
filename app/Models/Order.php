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

    const PAYMENT_ROLE_COD = 1;
    const PAYMENT_ROLE_VN_PAY = 2;
    const PAYMENT_ROLE_MOMO = 3;

    const STATUS_PAYMENT_PENDING = 1;
    const STATUS_PAYMENT_COMPLETED = 2;
    const STATUS_PAYMENT_CANCELED = 3;

    const STATUS_PENDING = 1;
    const STATUS_SHIPPING = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_CANCELED = 4;
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'id_order');
    }

    public function orderHistory()
    {
        return $this->hasMany(OrderHistory::class, 'id_order', 'id');
    }
}
