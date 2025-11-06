@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <h1 class="fw-semibold text-primary"><i class="fa-solid fa-user-group me-2"></i>Administrar Clientes</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
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
                                    <h5 class="card-title mb-1">Gestión de clientes</h5>
                                    <p class="text-muted small mb-0">
                                        Administra los clientes registrados en el sistema.
                                    </p>
                                </div>
                                <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-circle-plus me-1"></i>Nuevo cliente
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center datatable">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="text-center">Nombre completo</th>
                                            <th class="text-center">Tipo ID</th>
                                            <th class="text-center">Identificación</th>
                                            <th class="text-center">Teléfono</th>
                                            <th class="text-center">Correo</th>
                                            <th class="text-center">Ciudad</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($items->count())
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->full_name }}</td>
                                                    <td class="text-center">{{ $item->id_type }}</td>
                                                    <td class="text-center">{{ $item->identification }}</td>
                                                    <td class="text-center">{{ $item->phone }}</td>
                                                    <td class="text-center">{{ $item->email }}</td>
                                                    <td class="text-center">{{ $item->city }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <a href="{{ route('customers.edit', $item->id) }}"
                                                                class="btn btn-sm btn-outline-warning"
                                                                data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa-regular fa-pen-to-square"></i>
                                                            </a>
                                                            <form action="{{ route('customers.destroy', $item->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('¿Eliminar este cliente? Esta acción no se puede deshacer.');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
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
