<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'id_variant',
        'id_user',
        'quantity'
    ];

    public function variant(){
        return $this->belongsTo(Variant::class,'id_variant','id');
    }
}
