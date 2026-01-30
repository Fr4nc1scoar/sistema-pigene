<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_card', 
        'first_name', 'second_name', 'last_name', 'second_last_name',
        'birthdate', 'gender', 'marital_status',
        'address', 'phone', 'email',
        'education_level', 'profession',
        'photo_path',
        'employee_type', 
        'position_id', 
        'salary_scale_id', 
        'institution_entry_date', 
        'years_prior_service',      // Nuevo campo
        'medical_observations',     // Nuevo campo
        'salary_1', 'salary_2', 'salary_3', 'salary_4', 'salary_5', 'salary_6', // Nuevos campos
        // 'bank_name', 'account_type', 'account_number' // Eliminados anteriormente
    ];

    protected $casts = [
        'institution_entry_date' => 'date',
        // 'public_admin_entry_date' => 'date', // Eliminado
        'birthdate' => 'date',
        'years_prior_service' => 'integer',
        'salary_1' => 'decimal:2',
        'salary_2' => 'decimal:2',
        'salary_3' => 'decimal:2',
        'salary_4' => 'decimal:2',
        'salary_5' => 'decimal:2',
        'salary_6' => 'decimal:2',
    ];

    // Relaciones
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function salaryScale(): BelongsTo
    {
        return $this->belongsTo(SalaryScale::class);
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(Dependent::class);
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    public function economicConcepts(): BelongsToMany
    {
        return $this->belongsToMany(EconomicConcept::class, 'employee_economic_concepts')
                    ->withTimestamps();
    }

    public function pathologies(): BelongsToMany
    {
        return $this->belongsToMany(Pathology::class, 'employee_pathologies')
                    ->withTimestamps();
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'employee_medicines')
                    ->withTimestamps();
    }

    public function vacationBalances(): HasMany
    {
        return $this->hasMany(VacationBalance::class);
    }

    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class);
    }

    // Lógica de Negocio
    public function getYearsOfServiceAttribute(): int
    {
        // Años previos + Años en la institución
        $institutionYears = $this->institution_entry_date 
            ? Carbon::parse($this->institution_entry_date)->diffInYears(now()) 
            : 0;
            
        return (int) $this->years_prior_service + (int) $institutionYears;
    }

    public function getVacationDaysEntitlementAttribute(): int
    {
        $years = $this->years_of_service;

        if ($years <= 5) {
            return 30;
        } elseif ($years <= 10) {
            return 35;
        } else {
            return 57;
        }
    }
}
