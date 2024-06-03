<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbr',
        'editable',
        'user_id',
    ];

    protected $casts = [
        'editable' => 'boolean',
    ];
}
