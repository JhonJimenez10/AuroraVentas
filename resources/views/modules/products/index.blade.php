@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <h1 class="fw-semibold text-primary"><i class="fa-solid fa-boxes-stacked me-2"></i>Administrar Productos</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Productos</li>
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
                                    <h5 class="card-title mb-1">Gestión de productos</h5>
                                    <p class="text-muted small mb-0">
                                        Administra el stock, precios y estado de los productos en el sistema.
                                    </p>
                                </div>
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-circle-plus me-1"></i>Nuevo producto
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center datatable">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="text-center">Categoria</th>
                                            <th class="text-center">Proveedor</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Imagen</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Venta</th>
                                            <th class="text-center">Compra</th>
                                            <th class="text-center">Activo</th>
                                            <th class="text-center">Comprar</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($items as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->name_category }}</td>
                                                <td class="text-center">{{ $item->name_provider }}</td>
                                                <td class="text-center">{{ $item->code }}</td>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">
                                                    <img src="{{ asset('storage/' . $item->image_product) }}" alt=""
                                                        width="60" height="60">
                                                    <a href="{{ route('products.show.image', $item->image_id) }}"
                                                        class="badge rounded-pill bg-warning text-dark ms-1"
                                                        data-bs-toggle="tooltip" title="Editar imagen">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $item->description ?: '-' }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">${{ $item->sale_price }}</td>
                                                <td class="text-center">${{ $item->shopping_price }}</td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch d-flex justify-content-center">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="{{ $item->id }}" {{ $item->active ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('shopping.create', $item->id) }}"
                                                        class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                        title="Comprar producto">
                                                        Comprar
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('products.edit', $item->id) }}"
                                                            class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip"
                                                            title="Editar">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="{{ route('products.show', $item->id) }}"
                                                            class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                                            title="Eliminar">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center text-muted py-4">
                                                    <i class="fa-solid fa-circle-info me-1"></i>No hay productos
                                                    registrados.
                                                </td>
                                            </tr>
                                        @endforelse
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

            // Toggle activo
            $(document).on("change", ".form-check-input", function() {
                let id = $(this).attr('id');
                let active = $(this).is(':checked') ? 1 : 0;
                $.ajax({
                    url: "{{ url('products/update-active') }}/" + id + "/" + active,
                    type: "GET",
                    success: function(data) {
                        const success = data == 1;
                        Swal.fire({
                            icon: success ? 'success' : 'error',
                            title: success ? 'Éxito' : 'Error',
                            text: success ? 'Cambio de estado realizado correctamente' :
                                'No se pudo cambiar el estado',
                            timer: 3500,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });
        });
    </script>

    <style>
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-primary.btn-sm,
        .btn-info.btn-sm {
            font-weight: 500;
            border-radius: 0.4rem;
            padding: 0.45rem 0.9rem;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }

        .btn-primary.btn-sm:hover,
        .btn-info.btn-sm:hover {
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
