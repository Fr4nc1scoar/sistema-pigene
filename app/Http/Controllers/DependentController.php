<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use App\Models\Employee;
use Illuminate\Http\Request;

class DependentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'id_card' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'relationship' => 'required|string',
            'condition' => 'required|string',
        ]);

        $employee->dependents()->create($validated);

        return back()->with('success', 'Carga familiar agregada correctamente.')->with('tab', 'family');
    }

    public function destroy(Dependent $dependent)
    {
        $dependent->delete();
        return back()->with('success', 'Familiar eliminado.')->with('tab', 'family');
    }

    public function update(Request $request, Dependent $dependent)
    {
        $validated = $request->validate([
            'id_card' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'relationship' => 'required|string',
            'condition' => 'required|string',
        ]);

        $dependent->update($validated);

        return back()->with('success', 'Familiar actualizado.')->with('tab', 'family');
    }
}
