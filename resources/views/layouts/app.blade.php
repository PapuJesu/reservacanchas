<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Pilla Tu Cancha</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" style="position: relative;">
                <img src="{{ asset('storage/logo/logo.png') }}" 
                    alt="Pilla Tu Cancha" 
                    width="48" 
                    height="48" 
                    class="d-inline-block align-text-top me-2 my-n2" 
                    style="margin-top: -6px; margin-bottom: -6px; max-height: 48px;">
                    
                <span>Pilla Tu Cancha</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Canchas</a>
                    </li>
                    @if(session('usuario_id') === 6)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.canchas.index') }}">Admin Panel</a>
                        </li>
                    @endif

                    @if(session()->has('usuario_id'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuarios.show', session('usuario_id')) }}">Mis Reservas</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ session('usuario_nombre') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Salir</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        @if($message = session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($message = session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
    <!-- Footer -->
    <footer class="bg-light text-muted pt-5 pb-4 mt-5 border-top">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">
                
                <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-dark">Pilla Tu Cancha</h5>
                    <p class="small">
                        Plataforma para la gestión y reserva de canchas deportivas. Sistema en tiempo real para usuarios y administración.
                    </p>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-dark">Enlaces</h5>
                    <p><a href="{{ route('home') }}" class="text-muted text-decoration-none nav-link-hover">Ver Canchas</a></p>
                    @if(session('user_id'))
                        <p><a href="/dashboard" class="text-muted text-decoration-none nav-link-hover">Mis Reservas</a></p>
                    @else
                        <p><a href="/login" class="text-muted text-decoration-none nav-link-hover">Iniciar Sesión</a></p>
                    @endif
                    <p>
                        <a href="https://github.com/PapuJesu/reservacanchas" target="_blank" class="text-muted text-decoration-none nav-link-hover d-inline-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github me-2" viewBox="0 0 16 16">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                            </svg>
                            GitHub
                        </a>
                    </p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-dark">Contacto</h5>
                    <p class="small">Barranquilla, Colombia</p>
                    <p class="small">jcardenasv@cuc.edu.co</p>
                </div>
                
            </div>

            <hr class="mb-4">

            <div class="row align-items-center small">
                <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <p class="mb-0">© {{ date('Y') }} Pilla Tu Cancha. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-5 col-lg-4 text-center text-md-end mt-3 mt-md-0">
                    <span>Proyecto de Ingeniería de Sistemas - CUC</span>
                </div>
            </div>
        </div>
    </footer>

    <style>
        /* Un sub-rayado sutil al pasar el mouse por los links, estándar en la web */
        .nav-link-hover:hover {
            text-decoration: underline !important;
            color: #212529 !important; /* Gris oscuro default de Bootstrap */
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>