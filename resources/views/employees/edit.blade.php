@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <a href="{{ route('employees.index') }}" class="text-muted-2 text-decoration-none small d-inline-flex align-items-center gap-1 mb-3">
                <i class="bi bi-arrow-left"></i> Back to employees
            </a>
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <h1 class="h4 fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square text-primary"></i> Edit Employee
                    </h1>

                    <form method="POST" action="{{ route('employees.update', $employee) }}">
                        @csrf
                        @method('PUT')
                        @include('employees._form', ['employee' => $employee])
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Update Employee
                            </button>
                            <a href="{{ route('employees.index') }}" class="btn btn-light border">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
