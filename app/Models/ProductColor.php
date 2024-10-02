<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'attribute_color';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];
}
