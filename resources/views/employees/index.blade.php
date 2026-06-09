@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Employees</h1>
            <p class="text-muted-2 mb-0">{{ $employees->count() }} {{ Str::plural('employee', $employees->count()) }} across all departments</p>
        </div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Employee
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-clean align-middle mb-0">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Salary</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="employees-table-body">
                    @forelse ($employees as $employee)
                        <tr id="employee-row-{{ $employee->id }}">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="avatar">{{ Str::substr($employee->name, 0, 1) }}</span>
                                    <div>
                                        <div class="fw-semibold">{{ $employee->name }}</div>
                                        <div class="small text-muted-2">{{ $employee->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->position }}</td>
                            <td><span class="badge-soft">{{ $employee->department_name }}</span></td>
                            <td><span class="badge-salary">${{ number_format($employee->salary, 2) }}</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-light border btn-icon" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-light border btn-icon text-danger delete-employee" data-id="{{ $employee->id }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state text-center py-5">
                                    <i class="bi bi-people"></i>
                                    <p class="mb-2 mt-2">No employees yet.</p>
                                    <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">Add your first employee</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#employees-table-body').on('click', '.delete-employee', function () {
                if (!confirm('Are you sure you want to delete this employee?')) {
                    return;
                }

                const employeeId = $(this).data('id');

                $.ajax({
                    url: '/employees/' + employeeId,
                    type: 'DELETE',
                    success: function () {
                        $('#employee-row-' + employeeId).fadeOut(300, function () {
                            $(this).remove();
                        });
                    },
                    error: function () {
                        alert('Failed to delete employee. Please try again.');
                    }
                });
            });
        });
    </script>
@endpush
