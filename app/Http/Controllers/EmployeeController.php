<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = Employee::query()
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->select('employees.*', 'departments.name as department_name')
            ->orderBy('employees.name')
            ->get();

        $departments = Department::query()->orderBy('name')->get();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('employees.index');
    }

    public function store(EmployeeRequest $request): JsonResponse|RedirectResponse
    {
        $employee = Employee::query()->create($request->validated());
        $employee->load('department');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully.',
                'id' => $employee->id,
                'row' => view('employees._row', ['employee' => $employee])->render(),
            ]);
        }

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(Request $request, Employee $employee): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return response()->json([
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'position' => $employee->position,
                'salary' => $employee->salary,
                'department_id' => $employee->department_id,
            ]);
        }

        return redirect()->route('employees.index');
    }

    public function update(EmployeeRequest $request, Employee $employee): JsonResponse|RedirectResponse
    {
        $employee->update($request->validated());
        $employee->load('department');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully.',
                'id' => $employee->id,
                'mode' => 'update',
                'row' => view('employees._row', ['employee' => $employee])->render(),
            ]);
        }

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json(['success' => true]);
    }
}
