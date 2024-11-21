<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "combos";
    protected $fillable = [
        'name',
        'price',
        'description',
        'quantity',
        // 'id_product',
    ];
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'combo_products', 'id_combo', 'id_product');
    // }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'combo_products', 'id_combo', 'id_product')
            ->withPivot('id_variant') // Lấy thêm id_variant
            ->with(['variants.color', 'variants.size']);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($combo) {
            if ($combo->isForceDeleting()) {
                // Xóa cứng combo_products nếu xóa cứng combo
                $combo->products()->detach();
            } else {
                // Xóa mềm các bản ghi liên quan trong combo_products
                \DB::table('combo_products')
                    ->where('id_combo', $combo->id)
                    ->update(['deleted_at' => now()]);
            }
        });
    }
}
