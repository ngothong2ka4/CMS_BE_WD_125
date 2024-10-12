<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $fillable = [
        'id_product',
        'id_oder',
        'id_variant',
        'import_price',
        'list_price',
        'selling_price',
        'product_name',
        'product_image',
        'quantity'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'id_order','id');
    }

    public function orderVariant(){
        return $this->hasOne(Variant::class,'id','id_variant');
    }

}
