@extends('layouts.app')

@section('title', 'Departments')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Departments</h1>
        <p class="text-muted-2 mb-0">Organize your employees into departments</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle text-primary"></i> Add Department
                    </h2>
                    <form method="POST" action="{{ route('departments.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Department Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Engineering" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-1"></i> Add Department
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Employees</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="avatar avatar-sm"><i class="bi bi-building"></i></span>
                                            <span class="fw-semibold">{{ $department->name }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge-soft">{{ $department->employees_count }} {{ Str::plural('member', $department->employees_count) }}</span></td>
                                    <td class="text-end">
                                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this department and all its employees?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border btn-icon text-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state text-center py-5">
                                            <i class="bi bi-diagram-3"></i>
                                            <p class="mb-0 mt-2">No departments yet. Add one to get started.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
