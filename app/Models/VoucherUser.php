<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'voucher_user';

    protected $fillable = [
        'voucher_id',
        'user_id',
        'usage_count',
    ];
}
