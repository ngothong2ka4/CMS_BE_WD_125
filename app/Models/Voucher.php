<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_per_user',
        'status',
        'user_voucher_limit',
        'max_discount_amount',
        'min_accumulated_points',
        'max_accumulated_points',

    ];
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'product_voucher', 'id_voucher', 'id_product');
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'voucher_user_access', 'id_voucher', 'id_user');
    }

    public function isValid()
    {
        $currentDate = Carbon::now();

        if ($this->status != 1 || $this->usage_limit <= $this->used_count ||
            $this->start_date > $currentDate || $this->end_date < $currentDate) {
            return false;
        }

        $userUsageCount = DB::table('voucher_user')->where('voucher_id', $this->id)
                                                  ->where('user_id', Auth::id())
                                                  ->first();

        if ($userUsageCount && $userUsageCount->usage_count >= $this->usage_per_user) {
            return false;
        }


        return true;
    }

    public function calculateDiscount($orderAmount)
    {
        if ($this->discount_type == 1) {
            $discount = $orderAmount * ($this->discount_value / 100);
            return $this->max_discount_amount !== null ? min( $discount, $this->max_discount_amount) : $discount;
        } elseif ($this->discount_type == 2) {
            return min($this->discount_value, $orderAmount);
        }

        return 0;
    }

    public function incrementUsage($userId)
    {
        $this->used_count++;
        $this->save();
        if ($this->used_count == $this->usage_limit) {
            $this->update(['status' => 2]);
        }

        $voucherUser = DB::table('voucher_user')
            ->where('voucher_id', $this->id)
            ->where('user_id', $userId)
            ->first();

        if ($voucherUser) {
            DB::table('voucher_user')->where('id', $voucherUser->id)->increment('usage_count');
        } else {
            DB::table('voucher_user')->insert([
                'voucher_id' => $this->id,
                'user_id' => $userId,
                'usage_count' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
