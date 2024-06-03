<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'editable',
        'user_id',
    ];

    protected $cast = [
        'editable' => 'boolean',
    ];
}
