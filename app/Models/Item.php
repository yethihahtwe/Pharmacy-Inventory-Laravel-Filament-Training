<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'subcategory_id',
        'package_form_id',
        'editable',
        'user_id',
    ];

    protected $casts = [
        'editable'=> 'boolean',
    ];
}
