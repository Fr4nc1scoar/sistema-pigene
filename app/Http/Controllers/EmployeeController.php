<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['position', 'salaryScale']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('id_card', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereHas('position', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $employees = $query->paginate(15);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = \App\Models\Position::all();
        $scales = \App\Models\SalaryScale::all();
        
        $types = [
            'Legislador', 
            'Director', 
            'Empleado', 
            'Obrero', 
            'Contratado',
            'Legislador Jubilado', 
            'Director Jubilado', 
            'Empleados y Obreros Jubilados', 
            'Alto Funcionario Pensionado', 
            'Alto Nivel Pensionado', 
            'Empleados y Obreros Pensionados'
        ];
        
        return view('employees.create', compact('positions', 'scales', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_card' => 'required|numeric|unique:employees',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'salary_scale_id' => 'required|exists:salary_scales,id',
            'years_prior_service' => 'nullable|integer|min:0',
            'salary_1' => 'nullable|numeric',
        ]);

        $employee = Employee::create($request->all());

        return redirect()->route('employees.edit', $employee)->with('success', 'Trabajador creado correctamente. Ahora agregue Carga Familiar y/o Cuentas Bancarias.');
    }

    public function show(string $id)
    {
        // Re-dirigir al edit en modo readonly o mostrar ficha, user pidió poder editar.
        // Por ahora mantenemos show pero con link a edit.
        $employee = Employee::with(['position.direction', 'salaryScale'])->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $positions = \App\Models\Position::all();
        $scales = \App\Models\SalaryScale::all();
        
        $types = [
            'Legislador', 
            'Director', 
            'Empleado', 
            'Obrero', 
            'Contratado',
            'Legislador Jubilado', 
            'Director Jubilado', 
            'Empleados y Obreros Jubilados', 
            'Alto Funcionario Pensionado', 
            'Alto Nivel Pensionado', 
            'Empleados y Obreros Pensionados'
        ];

        return view('employees.edit', compact('employee', 'positions', 'scales', 'types'));
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        
        return redirect()->route('employees.edit', $employee)->with('success', 'Datos actualizados correctamente.');
    }

    public function destroy(string $id)
    {
        Employee::destroy($id);
        return redirect()->route('employees.index')->with('success', 'Trabajador eliminado.');
    }
}
