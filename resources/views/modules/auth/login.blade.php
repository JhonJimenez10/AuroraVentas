@extends('layouts.login')
@section('title', $title)

@section('content')
    <main class="login-page d-flex align-items-center justify-content-center min-vh-100 bg-light">

        <div class="container d-flex justify-content-center">
            <div class="login-card bg-white p-4 rounded-4 shadow-lg" style="width: 420px;">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="70" class="mb-3">
                    <h3 class="fw-bold text-dark mb-0">Aurora<span class="text-primary">Ventas</span></h3>
                    <p class="text-muted small">Sistema de gestión inteligente</p>
                </div>

                <!-- Bienvenida -->
                <div class="text-center mb-4">
                    <h5 class="fw-semibold text-dark">¡Bienvenido de nuevo!</h5>
                    <p class="text-muted small mb-0">Inicia sesión para continuar</p>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('login.post') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary fw-semibold">Correo electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email" class="form-control border-start-0"
                                placeholder="tu@correo.com" required>
                            <div class="invalid-feedback">Por favor ingrese su correo electrónico.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-secondary fw-semibold">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control border-start-0"
                                placeholder="********" required>
                            <div class="invalid-feedback">Por favor ingrese su contraseña.</div>
                        </div>
                        <div class="text-end mt-1">
                            <a href="#" class="text-decoration-none text-primary small">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                    </button>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mb-0 py-2">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>

                <!-- Pie -->
                <div class="text-center mt-4 small text-muted">
                    © {{ date('Y') }} <span class="fw-bold text-primary">SoftwareSolutions</span><br>
                    Todos los derechos reservados
                </div>
            </div>
        </div>

    </main>

    <style>
        .login-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .input-group-text {
            border-color: rgba(0, 0, 0, 0.15) !important;
        }

        .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            transition: all 0.25s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
        }

        .text-primary {
            color: #2563eb !important;
        }

        .bg-light {
            background-color: #f9fafb !important;
        }
    </style>
@endsection
