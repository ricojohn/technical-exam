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
    <div class="auth-wrap">
        <div class="card auth-card border-0">
            <div class="card-body p-4 p-sm-5">
                <div class="text-center mb-4">
                    <span class="brand-mark mx-auto mb-3" style="width:52px;height:52px;font-size:1.5rem;">
                        <i class="bi bi-people-fill"></i>
                    </span>
                    <h1 class="h5 fw-bold mb-1">{{ config('app.name') }}</h1>
                    <p class="text-muted-2 small mb-0">@yield('subtitle', 'Employee Management System')</p>
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
