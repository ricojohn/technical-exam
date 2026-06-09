@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Employees</h1>
            <p class="text-muted-2 mb-0" id="employee-count">{{ $employees->count() }} {{ Str::plural('employee', $employees->count()) }} across all departments</p>
        </div>
        <button type="button" class="btn btn-primary" id="add-employee-btn">
            <i class="bi bi-plus-lg me-1"></i> Add Employee
        </button>
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
                        @include('employees._row', ['employee' => $employee])
                    @empty
                        <tr id="employees-empty-row">
                            <td colspan="5">
                                <div class="empty-state text-center py-5">
                                    <i class="bi bi-people"></i>
                                    <p class="mb-2 mt-2">No employees yet.</p>
                                    <button type="button" class="btn btn-sm btn-primary" id="add-first-employee-btn">Add your first employee</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="employeeModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3">
                    <form id="employee-form">
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                                <select name="department_id" id="department_id" class="form-select" required>
                                    <option value="">Select a department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" id="name" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                <input type="text" name="position" id="position" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash"></i></span>
                                <input type="number" name="salary" id="salary" step="0.01" min="0" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="employee-form-submit">
                        <i class="bi bi-check-lg me-1"></i> <span id="employee-form-submit-label">Save Employee</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const modal = new bootstrap.Modal('#employeeModal');
            let mode = 'create';
            let employeeId = null;

            function clearFormErrors() {
                $('#employee-form .form-control, #employee-form .form-select').removeClass('is-invalid');
                $('#employee-form .invalid-feedback').text('');
            }

            function showFormErrors(errors) {
                $.each(errors, function (field, messages) {
                    const $field = $('#employee-form [name="' + field + '"]');
                    $field.addClass('is-invalid');
                    $field.closest('.input-group').find('.invalid-feedback').text(messages[0]);
                });
            }

            function showSuccessAlert(message) {
                const alert = $('<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center" role="alert">' +
                    '<i class="bi bi-check-circle-fill me-2"></i>' +
                    '<div>' + message + '</div>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('main.container').prepend(alert);
            }

            function updateEmployeeCount(delta) {
                const $count = $('#employee-count');
                const match = $count.text().match(/^(\d+)/);
                if (match) {
                    const newCount = Math.max(0, parseInt(match[1], 10) + delta);
                    const label = newCount === 1 ? 'employee' : 'employees';
                    $count.text(newCount + ' ' + label + ' across all departments');
                }
            }

            function openCreateModal() {
                mode = 'create';
                employeeId = null;
                clearFormErrors();
                $('#employee-form')[0].reset();
                $('#employeeModalLabel').text('Add Employee');
                $('#employee-form-submit-label').text('Save Employee');
                modal.show();
            }

            $('#add-employee-btn').on('click', openCreateModal);
            $(document).on('click', '#add-first-employee-btn', openCreateModal);

            $('#employees-table-body').on('click', '.edit-employee', function () {
                const id = $(this).data('id');
                clearFormErrors();

                $.ajax({
                    url: '/employees/' + id + '/edit',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        mode = 'update';
                        employeeId = data.id;
                        $('#department_id').val(data.department_id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#position').val(data.position);
                        $('#salary').val(data.salary);
                        $('#employeeModalLabel').text('Edit Employee');
                        $('#employee-form-submit-label').text('Update Employee');
                        modal.show();
                    },
                    error: function () {
                        alert('Failed to load employee. Please try again.');
                    }
                });
            });

            $('#employee-form-submit').on('click', function () {
                clearFormErrors();

                const url = mode === 'create' ? '/employees' : '/employees/' + employeeId;
                const method = mode === 'create' ? 'POST' : 'POST';
                const data = $('#employee-form').serialize();

                const payload = mode === 'update' ? data + '&_method=PUT' : data;

                $.ajax({
                    url: url,
                    type: method,
                    data: payload,
                    dataType: 'json',
                    success: function (response) {
                        modal.hide();

                        if (mode === 'update') {
                            $('#employee-row-' + response.id).replaceWith(response.row);
                        } else {
                            $('#employees-empty-row').remove();
                            $('#employees-table-body').append(response.row);
                            updateEmployeeCount(1);
                        }

                        showSuccessAlert(response.message);
                    },
                    error: function (xhr) {
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            showFormErrors(xhr.responseJSON.errors);
                        } else {
                            alert('Failed to save employee. Please try again.');
                        }
                    }
                });
            });

            $('#employees-table-body').on('click', '.delete-employee', function () {
                if (!confirm('Are you sure you want to delete this employee?')) {
                    return;
                }

                const id = $(this).data('id');

                $.ajax({
                    url: '/employees/' + id,
                    type: 'DELETE',
                    success: function () {
                        $('#employee-row-' + id).fadeOut(300, function () {
                            $(this).remove();
                            updateEmployeeCount(-1);

                            if ($('#employees-table-body tr').length === 0) {
                                $('#employees-table-body').html(
                                    '<tr id="employees-empty-row"><td colspan="5">' +
                                    '<div class="empty-state text-center py-5">' +
                                    '<i class="bi bi-people"></i>' +
                                    '<p class="mb-2 mt-2">No employees yet.</p>' +
                                    '<button type="button" class="btn btn-sm btn-primary" id="add-first-employee-btn">Add your first employee</button>' +
                                    '</div></td></tr>'
                                );
                            }
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
