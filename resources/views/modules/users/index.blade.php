@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <h1 class="fw-semibold text-primary"><i class="fa-solid fa-users-gear me-2"></i>Administrar Usuarios</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="card-title mb-1">Gestión de cuentas</h5>
                                    <p class="text-muted small mb-0">Administra los usuarios, sus roles y estado de acceso.
                                    </p>
                                </div>
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-user-plus me-1"></i>Nuevo usuario
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Rol</th>
                                            <th class="text-center">Cambio password</th>
                                            <th class="text-center">Activo</th>
                                            <th class="text-center">Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @include('modules.users.tbody')
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('modules.users.modal_update_password')
@endsection

@push('scripts')
    <script>
        function loadTbody() {
            $.ajax({
                url: "{{ route('users.tbody') }}",
                type: "GET",
                success: function(data) {
                    $('#tbody').html(data);
                }
            });
        }

        function updateActive(id, active) {
            $.ajax({
                url: "{{ url('users/update-active') }}/" + id + "/" + active,
                type: "GET",
                success: function(data) {
                    const success = data == 1;
                    Swal.fire({
                        icon: success ? 'success' : 'error',
                        title: success ? 'Éxito' : 'Error',
                        text: success ?
                            'Cambio de estado realizado correctamente' : 'No se pudo cambiar el estado',
                        timer: 3500,
                        confirmButtonText: 'Aceptar'
                    });
                    if (success) loadTbody();
                }
            });
        }

        function add_id_user(id) {
            $('#user_id').val(id);
        }

        function update_password() {
            const id = $('#user_id').val();
            const password = $('#password').val();
            $.ajax({
                url: "{{ url('users/update-password') }}/" + id + "/" + password,
                type: "GET",
                success: function(data) {
                    const success = data == 1;
                    Swal.fire({
                        icon: success ? 'success' : 'error',
                        title: success ? 'Éxito' : 'Error',
                        text: success ?
                            'Cambio de password realizado correctamente' :
                            'Cambio de password no realizado',
                        timer: 3500,
                        confirmButtonText: 'Aceptar'
                    });
                    if (success) $('#form_update_password')[0].reset();
                }
            });
            return false;
        }

        $(document).ready(function() {
            $(document).on('change', '.form-check-input', function() {
                const id = $(this).attr('id');
                const active = $(this).is(':checked') ? 1 : 0;
                updateActive(id, active);
            });
        });
    </script>

    <style>
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-primary.btn-sm {
            font-weight: 500;
            border-radius: 0.4rem;
            padding: 0.45rem 0.9rem;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }

        .btn-primary.btn-sm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        table thead th {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        table tbody tr:hover {
            background-color: #f9fafb;
        }

        .table td {
            font-size: 0.9rem;
            color: #4b5563;
        }
    </style>
@endpush
