<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'variants';
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function color(){
        return $this->hasOne(ProductColor::class,'id','id_attribute_color');
    }
    
    public function size(){
        return $this->hasOne(ProductSize::class,'id','id_attribute_size');
    }
}
