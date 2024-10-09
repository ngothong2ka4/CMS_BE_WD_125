<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;
<<<<<<< HEAD
=======

>>>>>>> 0ab63c190207585db7fdb0e2974fba2b4b12d74f
    
    protected $table = 'product_images';
    protected $guarded = [];
}
