<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditObserver
{
    public function created(Model $model): void
    {
        $this->log($model, 'Create', null, $model->toArray());
    }

    public function updated(Model $model): void
    {
        // Obtener solo los campos modificados
        $changes = $model->getChanges();
        $original = $model->getOriginal();
        
        $old_values = [];
        $new_values = [];

        foreach ($changes as $key => $value) {
            // Ignorar timestamps si no son relevantes (opcional, aquí los incluimos)
            if ($key === 'updated_at') continue;

            $old_values[$key] = $original[$key] ?? null;
            $new_values[$key] = $value;
        }

        if (!empty($new_values)) {
            $this->log($model, 'Update', $old_values, $new_values);
        }
    }

    public function deleted(Model $model): void
    {
        $this->log($model, 'Delete', $model->toArray(), null);
    }

    protected function log(Model $model, string $action, ?array $old, ?array $new): void
    {
        AuditLog::create([
            'user_id' => Auth::id(), // Puede ser null si es una tarea en segundo plano o seeder
            'action' => $action,
            'table_name' => $model->getTable(),
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => Request::ip(),
        ]);
    }
}
