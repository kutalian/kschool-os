<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .content {
            padding: 20px;
        }

        .card {
            border: none;
            shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="sidebar col-md-2 d-none d-md-block">
            <h3 class="p-3">School ERP</h3>
            <a href="{{ route('dashboard') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
            <a href="#"><i class="fas fa-user-graduate me-2"></i> Students</a>
            <a href="#"><i class="fas fa-chalkboard-teacher me-2"></i> Staff</a>
            <a href="#"><i class="fas fa-school me-2"></i> Classes</a>
            <a href="#"><i class="fas fa-book me-2"></i> Exams</a>
        </div>
        <div class="col-md-10 w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
                <div class="container-fluid">
                    <span class="navbar-brand">Dashboard</span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>