<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'id_category','id');
    }

    public function material(){
        return $this->belongsTo(Material::class,'id_materials','id');
    }

    public function stone(){
        return $this->belongsTo(Stone::class,'id_stones','id');
    }

    public function variants(){
        return $this->hasMany(Variant::class,'id_product','id');
    }
    public function images(){
        return $this->hasMany(ProductImage::class,'id_product','id');
    }
}
