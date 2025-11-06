@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="fw-bold mb-1">🧾 Detalle de la Venta</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('sales.detail-sale') }}">Ventas</a></li>
                        <li class="breadcrumb-item active">Detalle</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('sales.detail-sale') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div><!-- End Page Title -->

        <section class="section mt-4">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title fw-bold mb-0">Información de la Venta</h5>
                                <span class="badge bg-success fs-6 px-3 py-2">Completada</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="info-box bg-light p-3 rounded-3">
                                        <p class="mb-1 text-muted"><i class="fa-solid fa-user"></i> Usuario</p>
                                        <h6 class="fw-semibold">{{ $sale->user_name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light p-3 rounded-3">
                                        <p class="mb-1 text-muted"><i class="fa-solid fa-calendar"></i> Fecha</p>
                                        <h6 class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($sale->created_at)->format('Y-m-d H:i') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light p-3 rounded-3">
                                        <p class="mb-1 text-muted"><i class="fa-solid fa-dollar-sign"></i> Total Venta</p>
                                        <h5 class="fw-bold text-success">${{ number_format($sale->total_sale, 2) }}</h5>
                                    </div>
                                </div>
                            </div>

                            {{-- 🔹 Datos del Cliente --}}
                            <hr class="my-4">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-id-card"></i> Datos del Cliente</h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="info-box bg-light p-3 rounded-3 h-100">
                                        <p class="mb-1 text-muted"><i class="fa-solid fa-user"></i> Nombre</p>
                                        <h6 class="fw-semibold mb-2">{{ $sale->customer_full_name ?? '—' }}</h6>

                                        <div class="d-flex flex-wrap gap-3 small text-muted">
                                            <span><strong>Tipo:</strong> {{ $sale->customer_id_type ?? '—' }}</span>
                                            <span><strong>Identificación:</strong>
                                                {{ $sale->customer_identification ?? '—' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box bg-light p-3 rounded-3 h-100">
                                        <p class="mb-1 text-muted"><i class="fa-solid fa-address-book"></i> Contacto</p>
                                        <div class="small text-muted">
                                            <div><strong>Teléfono:</strong> {{ $sale->customer_phone ?? '—' }}</div>
                                            <div><strong>Correo:</strong> {{ $sale->customer_email ?? '—' }}</div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="small text-muted">
                                            <strong>Dirección:</strong>
                                            {{ collect([$sale->customer_city ?? null, $sale->customer_canton ?? null, $sale->customer_province ?? null, $sale->customer_address ?? null])->filter()->implode(' • ') ?:'—' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-box"></i> Productos Vendidos</h5>

                            <div class="table-responsive">
                                <table id="detailsTable" class="table table-hover align-middle">
                                    <thead class="table-primary">
                                        <tr class="text-center">
                                            <th class="text-center">Producto</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Precio Unitario</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $item)
                                            <tr class="text-center">
                                                <td class="text-center">{{ $item->product_name }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">${{ number_format($item->unit_price, 2) }}</td>
                                                <td class="text-center fw-semibold text-success">
                                                    ${{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('sales.detail.ticket', $sale->id) }}" target="_blank"
                                    class="btn btn-success px-4">
                                    <i class="fa-solid fa-print"></i> Imprimir Ticket
                                </a>
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
            // Inicializar DataTable solo una vez
            if (!$.fn.DataTable.isDataTable('#detailsTable')) {
                $('#detailsTable').DataTable({
                    pageLength: 5,
                    lengthChange: false,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json'
                    },
                    columnDefs: [{
                        orderable: false,
                        targets: [0, 1, 2, 3]
                    }]
                });
            }
        });
    </script>
@endpush
