<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigAds extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'config_ads';
    protected $guarded = [];
}
