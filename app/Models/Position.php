<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = ['code', 'name', 'direction_id', 'level'];

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
