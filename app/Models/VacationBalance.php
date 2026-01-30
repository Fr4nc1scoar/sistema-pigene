<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacationBalance extends Model
{
    protected $fillable = ['employee_id', 'period', 'remaining_days'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
