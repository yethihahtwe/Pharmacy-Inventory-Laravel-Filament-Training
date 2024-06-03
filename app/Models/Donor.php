<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'editable',
        'user_id',
    ];

    protected $casts = [
        'editable'=> 'boolean',
    ];
}
