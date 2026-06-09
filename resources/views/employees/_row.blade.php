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
    <td><span class="badge-soft">{{ $employee->department_name ?? optional($employee->department)->name }}</span></td>
    <td><span class="badge-salary">${{ number_format($employee->salary, 2) }}</span></td>
    <td class="text-end">
        <div class="d-inline-flex gap-1">
            <button type="button" class="btn btn-sm btn-light border btn-icon edit-employee" data-id="{{ $employee->id }}" title="Edit">
                <i class="bi bi-pencil"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light border btn-icon text-danger delete-employee" data-id="{{ $employee->id }}" title="Delete">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </td>
</tr>
