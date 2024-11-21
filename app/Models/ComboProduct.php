<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComboProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id_combo',
        'id_product'
    ];
    public function combos()
    {
        return $this->belongsTo(Combo::class, 'id_combo');
    }
    public function products()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'id_variant', 'id');
    }
}
