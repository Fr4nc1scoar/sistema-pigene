<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dependent extends Model
{
    protected $fillable = ['employee_id', 'id_card', 'name', 'birthdate', 'relationship', 'condition', 'has_disability'];

    protected $casts = [
        'birthdate' => 'date',
        'has_disability' => 'boolean',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
