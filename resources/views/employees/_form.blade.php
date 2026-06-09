<div class="mb-3">
    <label for="department_id" class="form-label">Department</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
        <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
            <option value="">Select a department</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id ?? null) == $department->id)>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input type="text" name="name" id="name" value="{{ old('name', $employee->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input type="email" name="email" id="email" value="{{ old('email', $employee->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="position" class="form-label">Position</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
        <input type="text" name="position" id="position" value="{{ old('position', $employee->position ?? '') }}" class="form-control @error('position') is-invalid @enderror" required>
        @error('position')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-4">
    <label for="salary" class="form-label">Salary</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-cash"></i></span>
        <input type="number" name="salary" id="salary" step="0.01" min="0" value="{{ old('salary', $employee->salary ?? '') }}" class="form-control @error('salary') is-invalid @enderror" required>
        @error('salary')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
