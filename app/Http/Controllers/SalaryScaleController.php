<?php

namespace App\Http\Controllers;

use App\Models\SalaryScale;
use Illuminate\Http\Request;

class SalaryScaleController extends Controller
{
    public function index()
    {
        $scales = SalaryScale::paginate(10);
        return view('salary_scales.index', compact('scales'));
    }

    public function create()
    {
        return view('salary_scales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:salary_scales',
            'amount' => 'required|numeric|min:0'
        ]);
        SalaryScale::create($request->all());
        return redirect()->route('salary-scales.index')->with('success', 'Tabulador creado.');
    }

    public function edit(SalaryScale $salaryScale)
    {
        return view('salary_scales.edit', compact('salaryScale'));
    }

    public function update(Request $request, SalaryScale $salaryScale)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:salary_scales,code,' . $salaryScale->id,
            'amount' => 'required|numeric|min:0'
        ]);
        $salaryScale->update($request->all());
        return redirect()->route('salary-scales.index')->with('success', 'Tabulador actualizado.');
    }

    public function destroy(SalaryScale $salaryScale)
    {
        $salaryScale->delete();
        return redirect()->route('salary-scales.index')->with('success', 'Tabulador eliminado.');
    }
}
