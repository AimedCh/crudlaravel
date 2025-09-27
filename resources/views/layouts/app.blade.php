<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2Pkf6K8wSok0f6PLQ4KJIp4jKAmVKb4jGQIlxZq2Q8Q+XQ5Fh0kB8Qd1+A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Fallback Font Awesome from different CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
    
    <!-- CSS Unificado para Backend -->
    <style>
        /* Diseño unificado simple */
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f8f9fa;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #ffffff;
            --dark-color: #343a40;
            --border-color: #dee2e6;
            --shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .unified-card {
            background: var(--light-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        .unified-header {
            background: var(--primary-color);
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .unified-body {
            padding: 20px;
        }

        .unified-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .unified-table th {
            background: var(--secondary-color);
            color: var(--dark-color);
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
        }

        .unified-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .unified-table tr:hover {
            background-color: #f8f9fa;
        }

        .unified-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .unified-btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .unified-btn-primary:hover {
            background: #357abd;
            color: white;
        }

        .unified-btn-success {
            background: var(--success-color);
            color: white;
        }

        .unified-btn-success:hover {
            background: #218838;
            color: white;
        }

        .unified-btn-warning {
            background: var(--warning-color);
            color: var(--dark-color);
        }

        .unified-btn-warning:hover {
            background: #e0a800;
            color: var(--dark-color);
        }

        .unified-btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .unified-btn-danger:hover {
            background: #c82333;
            color: white;
        }

        .unified-form-group {
            margin-bottom: 15px;
        }

        .unified-form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .unified-form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .unified-form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .unified-alert {
            padding: 12px 16px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .unified-alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .unified-alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .unified-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .unified-badge-success {
            background: var(--success-color);
            color: white;
        }

        .unified-badge-warning {
            background: var(--warning-color);
            color: var(--dark-color);
        }

        .unified-badge-danger {
            background: var(--danger-color);
            color: white;
        }

        .unified-badge-info {
            background: var(--info-color);
            color: white;
        }

        /* Fallback para iconos */
        .fas, .far, .fab {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }
        .fa-eye:before { content: "👁"; }
        .fa-edit:before { content: "✏"; }
        .fa-trash:before { content: "🗑"; }
        .fa-plus:before { content: "➕"; }
        .fa-list:before { content: "📋"; }
        .fa-file-pdf:before { content: "📄"; }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Clientes y Facturas eliminados -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.proveedores.index') }}">{{ _('proveedores') }}</a>
                            </li>
                             

                            <!-- Recibos eliminado -->
                            
                            <!-- AirPods eliminado -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reservas') }}">Reservas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.airpods-purchases.index') }}">Compras AirPods</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.contacto.index') }}">Contacto</a>
                            </li>
                            <!-- Órdenes eliminado -->
                          
             
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if(Auth::guard('admin')->check())
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-shield me-1"></i>
                                    {{ Auth::guard('admin')->user()?->name ?? 'Administrador' }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('admin-logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @elseif(Auth::guard('web')->check())
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user me-1"></i>
                                    {{ Auth::guard('web')->user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('client.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('client-logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="client-logout-form" action="{{ route('client.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client.login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>
                                    {{ __('Iniciar Sesión') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
