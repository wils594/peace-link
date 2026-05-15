<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'type',
        'description',
        'danger_level',
        'zone',
        'district',
        'latitude',
        'longitude',
        'anonymous',
        'status',
    ];
}