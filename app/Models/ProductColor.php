<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;
    protected $table = 'attribute_color';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];
}
