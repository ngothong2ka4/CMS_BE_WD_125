<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;
    protected $table = 'order_history';
    protected $guarded = [];

    public function idUser()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

}
