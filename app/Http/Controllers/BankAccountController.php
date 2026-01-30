<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Employee;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string|size:20',
            'type' => 'required|string',
            'is_active' => 'boolean',
        ]);

        if ($request->has('is_active') && $request->is_active) {
             // Desactivar otras si queremos obligar unicidad de pago
        }

        $employee->bankAccounts()->create([
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'type' => $validated['type'],
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return back()->with('success', 'Cuenta bancaria agregada.')->with('tab', 'organization');
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string|size:20',
            'type' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $bankAccount->update([
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'type' => $validated['type'],
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return back()->with('success', 'Cuenta bancaria actualizada.')->with('tab', 'organization');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return back()->with('success', 'Cuenta bancaria eliminada.')->with('tab', 'organization');
    }

    public function toggle(BankAccount $bankAccount)
    {
        $bankAccount->update(['is_active' => !$bankAccount->is_active]);
        return back()->with('success', 'Estatus de cuenta actualizado.')->with('tab', 'organization');
    }
}
