<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SocialWelfareController extends Controller
{
    /**
     * Display a listing of the resource with filters.
     */
    public function index(Request $request)
    {
        $query = Employee::query()->with(['position', 'dependents', 'pathologies']);

        // Filtro Búsqueda General (Nombre o Cédula)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('id_card', 'like', "%{$search}%");
            });
        }

        // Filtro por Profesión (LIKE)
        if ($request->filled('profession')) {
            $query->where('profession', 'like', '%' . $request->profession . '%');
        }

        // Filtro por Tipo de Personal
        if ($request->filled('employee_type')) {
            $query->where('employee_type', $request->employee_type);
        }

        // Filtro por Género
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filtro por Cargo
        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        // Filtro por Mes de Cumpleaños
        if ($request->filled('birthday_month')) {
            $query->whereMonth('birthdate', $request->birthday_month);
        }

        // Filtro por Rango de Edad
        if ($request->filled('age_min')) {
            $date = Carbon::now()->subYears($request->age_min)->format('Y-m-d');
            $query->whereDate('birthdate', '<=', $date);
        }

        if ($request->filled('age_max')) {
            $date = Carbon::now()->subYears($request->age_max + 1)->format('Y-m-d');
            $query->whereDate('birthdate', '>', $date);
        }

        // Filtro Hijos (Tiene hijos?)
        if ($request->has('has_children')) {
            $query->has('dependents');
        }

        // Filtro Patologías (Tiene patologías / observaciones médicas?)
        if ($request->has('has_pathologies')) {
            // Asumimos 'medical_observations' no nulo o relación pathologies existente
            $query->where(function($q) {
                 $q->whereNotNull('medical_observations')->where('medical_observations', '!=', '')
                   ->orHas('pathologies');
            });
        }
        
        $employees = $query->with(['position', 'dependents', 'pathologies', 'bankAccounts'])->get(); 

        // Exportación a Excel (CSV)
        if ($request->has('export_excel')) {
            $fileName = 'reporte_bienestar_social_' . date('Y-m-d_H-i') . '.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $callback = function() use ($employees) {
                $file = fopen('php://output', 'w');
                
                // BOM para Excel (UTF-8)
                fputs($file, "\xEF\xBB\xBF");

                // Cabeceras
                fputcsv($file, [
                    'Cédula', 
                    'Apellidos', 
                    'Nombres', 
                    'Tipo Trabajador', 
                    'Cargo', 
                    'Género', 
                    'Fecha Nacimiento', 
                    'Edad', 
                    'Nivel Educativo', 
                    'Profesión', 
                    'Cuentas Bancarias', 
                    'Datos Médicos', 
                    'Carga Familiar'
                ], ';');

                foreach ($employees as $emp) {
                    // Formatear Cuentas
                    $cuentas = $emp->bankAccounts->map(function($acc) {
                        return $acc->bank_name . ': ' . $acc->account_number . ' (' . $acc->type . ')';
                    })->join(' | ');

                    // Formatear Médicos
                    $medicos = $emp->medical_observations;
                    if($emp->pathologies->count() > 0) {
                        $medicos .= ' | Patologías: ' . $emp->pathologies->pluck('name')->join(', ');
                    }

                    // Formatear Carga Familiar
                    $familia = $emp->dependents->map(function($dep) {
                        return $dep->name . ' (' . $dep->relationship . ', ' . $dep->birthdate->age . ' años) CI:' . ($dep->id_card ?? 'N/A') . ' Cond:' . $dep->condition;
                    })->join(" \n ");

                    fputcsv($file, [
                        $emp->id_card,
                        $emp->last_name . ' ' . $emp->second_last_name,
                        $emp->first_name . ' ' . $emp->second_name,
                        $emp->employee_type,
                        $emp->position->name,
                        $emp->gender,
                        $emp->birthdate ? $emp->birthdate->format('d/m/Y') : '',
                        $emp->birthdate ? $emp->birthdate->age : '',
                        $emp->education_level,
                        $emp->profession,
                        $cuentas,
                        $medicos,
                        $familia
                    ], ';');
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } 

        // Catálogos para filtros
        $positions = \App\Models\Position::all();
        
        $types = [
            'Legislador', 'Director', 'Empleado', 'Obrero', 'Contratado',
            'Legislador Jubilado', 'Director Jubilado', 
            'Empleados y Obreros Jubilados', 'Alto Funcionario Pensionado', 
            'Alto Nivel Pensionado', 'Empleados y Obreros Pensionados'
        ];

        return view('social_welfare.index', compact('employees', 'positions', 'types'));
    }
}
