<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $table = 'calendars';

    protected $fillable = [
        'name',
        'year'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
}
