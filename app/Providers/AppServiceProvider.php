<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Employee;
use App\Models\SalaryScale;
use App\Models\VacationBalance;
use App\Observers\AuditObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Employee::observe(AuditObserver::class);
        SalaryScale::observe(AuditObserver::class);
        VacationBalance::observe(AuditObserver::class);
    }
}
