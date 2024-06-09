<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
        'township_id',
        'has_parent',
        'parent_id',
        'user_id',
        'organization_id',
    ];

    protected $casts = [
        'has_parent' => 'boolean',
    ];

    //     township
    // state
    // parent
    // organization
    // user
    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'parent_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
