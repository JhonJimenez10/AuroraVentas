@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <!-- Encabezado -->
        <div class="pagetitle mb-4">
            <h1 class="fw-semibold text-primary"><i class="fa-solid fa-receipt me-2"></i>Consulta de Ventas</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Ventas</li>
                    <li class="breadcrumb-item active">Consulta</li>
                </ol>
            </nav>
        </div>

        <!-- Sección principal -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="card-title mb-1">Historial de Ventas</h5>
                                    <p class="text-muted small mb-0">
                                        Consulta todas las ventas registradas en el sistema.
                                    </p>
                                </div>
                            </div>

                            <!-- Tabla -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center" id="sales_table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Total Vendido</th>
                                            <th class="text-center">Fecha de Venta</th>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Detalle</th>
                                            <th class="text-center">Ticket</th>
                                            <th class="text-center">Anular</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td class="text-center">
                                                    <strong>${{ number_format($item->total_sale, 2) }}</strong></td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                                                <td class="text-center">{{ $item->user_name }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('sales.detail-sale.id', $item->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fa-solid fa-eye me-1"></i> Ver
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a target="_blank" href="{{ route('sales.detail.ticket', $item->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fa-solid fa-print me-1"></i> Ticket
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('sales.annul-sale.id', $item->id) }}"
                                                        method="POST" class="d-inline form-annul">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fa-solid fa-ban me-1"></i> Anular
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
        $(document).ready(function() {

            // Inicializar DataTable sin re-inicializarla varias veces
            if (!$.fn.DataTable.isDataTable('#sales_table')) {
                $('#sales_table').DataTable({
                    order: [
                        [1, 'desc']
                    ],
                    pageLength: 5,
                    language: {
                        decimal: "",
                        emptyTable: "No hay información disponible",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 a 0 de 0 registros",
                        infoFiltered: "(filtrado de _MAX_ registros totales)",
                        lengthMenu: "Mostrar _MENU_ registros",
                        loadingRecords: "Cargando...",
                        processing: "Procesando...",
                        search: "Buscar:",
                        zeroRecords: "No se encontraron coincidencias",
                        paginate: {
                            first: "<<",
                            last: ">>",
                            next: ">",
                            previous: "<"
                        }
                    }
                });
            }

            // Confirmación moderna al anular venta
            $('.form-annul').on('submit', function(e) {
                e.preventDefault();
                let form = this;

                Swal.fire({
                    title: '¿Anular esta venta?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, anular',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
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

        .btn {
            border-radius: 0.4rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-info {
            background-color: #17a2b8;
            border: none;
        }

        .btn-success {
            background-color: #198754;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .table thead th {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .table tbody td {
            font-size: 0.9rem;
            color: #4b5563;
        }

        .table-hover tbody tr:hover {
            background-color: #f9fafb;
        }
    </style>
@endpush
