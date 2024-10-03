<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_category',
        'id_materials',
        'id_stones',
        'name',
        'description',
        'thumbnail',
        'sold'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class,'id_category');
    }
    public function material()
    {
        return $this->belongsTo(Material::class,'id_materials');
    }
    public function stone()
    {
        return $this->belongsTo(Stone::class,'id_stones');
    }
}
