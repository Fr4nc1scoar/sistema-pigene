<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryScale extends Model
{
    protected $fillable = ['code', 'grade', 'step', 'amount'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
