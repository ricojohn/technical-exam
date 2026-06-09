<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg app-navbar sticky-top py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('employees.index') }}">
                <span class="brand-mark"><i class="bi bi-people-fill"></i></span>
                <span>{{ config('app.name') }}</span>
            </a>
            @if ($authUser)
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('employees.index') }}" class="nav-pill d-none d-sm-inline-flex align-items-center gap-1 {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i> Employees
                    </a>
                    <a href="{{ route('departments.index') }}" class="nav-pill d-none d-sm-inline-flex align-items-center gap-1 {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3"></i> Departments
                    </a>
                    <div class="vr d-none d-sm-block opacity-25"></div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="avatar avatar-sm">{{ \Illuminate\Support\Str::substr($authUser->name, 0, 1) }}</span>
                        <span class="d-none d-md-inline small fw-semibold">{{ $authUser->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm border" title="Logout">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
