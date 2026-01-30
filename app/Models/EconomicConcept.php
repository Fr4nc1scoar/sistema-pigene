<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EconomicConcept extends Model
{
    protected $fillable = ['name', 'type', 'is_fixed'];

    protected $casts = [
        'is_fixed' => 'boolean',
    ];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_economic_concepts');
    }
}
