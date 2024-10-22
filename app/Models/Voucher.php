<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id_product',
        'code',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_per_user',
        'status',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function isValid($orderAmount, $userId)
    {
        $currentDate = Carbon::now();

        if ($this->status != 1 || $this->usage_limit <= $this->used_count || 
            $this->start_date > $currentDate || $this->end_date < $currentDate) {
            return false;
        }

        $userUsageCount = DB::table('voucher_user')->where('voucher_id', $this->id)
                                                  ->where('user_id', $userId)
                                                  ->count();
        if ($userUsageCount >= $this->usage_per_user) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderAmount)
    {
        if ($this->discount_type == 1) { 
            return $orderAmount * ($this->discount_value / 100);
        } elseif ($this->discount_type == 2) {
            return min($this->discount_value, $orderAmount);
        }

        return 0;
    }

    public function incrementUsage($userId)
    {
        $this->used_count++;
        $this->save();

        DB::table('voucher_user')->insert([
            'voucher_id' => $this->id,
            'user_id' => $userId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
