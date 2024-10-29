<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory;
    protected $table = 'product_views';
    protected $fillable=[
        'id_product',
        'viewed_at',
        'id_user',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'id_product','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }
    
}
