@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <a href="{{ route('employees.index') }}" class="text-muted-2 text-decoration-none small d-inline-flex align-items-center gap-1 mb-3">
                <i class="bi bi-arrow-left"></i> Back to employees
            </a>
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <h1 class="h4 fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus text-primary"></i> Add Employee
                    </h1>

                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf
                        @include('employees._form')
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Save Employee
                            </button>
                            <a href="{{ route('employees.index') }}" class="btn btn-light border">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
