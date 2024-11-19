<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdsService extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ads_services';
    protected $guarded = [];
}
