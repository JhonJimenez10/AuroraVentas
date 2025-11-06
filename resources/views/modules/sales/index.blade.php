@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <h1 class="fw-semibold text-primary"><i class="fa-solid fa-cash-register me-2"></i>Ventas de Productos</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Ventas</li>
                </ol>
            </nav>
        </div>
        <!-- Sección del cliente -->
        <section class="section mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="card-title mb-1">Cliente</h5>
                                    <p class="text-muted small mb-0">Busca por cédula o nombre. Si no existe, créalo aquí
                                        mismo.</p>
                                </div>

                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalCreateCustomer">
                                    <i class="fa-solid fa-user-plus me-1"></i> Nuevo cliente
                                </button>
                            </div>

                            {{-- Buscador --}}
                            <div class="input-group mb-3">
                                <input type="text" id="customer_search" class="form-control"
                                    placeholder="Buscar por cédula o nombre...">
                                <button id="btn_search_customer" class="btn btn-outline-secondary" type="button"
                                    title="Buscar">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>

                            {{-- Resultados --}}
                            <ul id="customer_results" class="list-group mb-3" style="display:none;"></ul>

                            {{-- Seleccionado --}}
                            <div id="customer_selected_card" class="card border-0" style="display:none;">
                                <div class="card-body p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold" id="c_full_name"></div>
                                            <div class="small text-muted">
                                                <span id="c_id_type"></span>:
                                                <span id="c_identification"></span> •
                                                <span id="c_phone"></span> •
                                                <span id="c_email"></span>
                                            </div>
                                            <div class="small text-muted" id="c_address"></div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger" id="btn_clear_customer">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden para enviar en la venta --}}
                            <input type="hidden" id="customer_id" form="form_sale_submit" name="customer_id">

                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Sección de productos disponibles -->
        <section class="section mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="card-title mb-1">Productos disponibles</h5>
                                    <p class="text-muted small mb-0">
                                        Selecciona los productos que deseas agregar al carrito de venta.
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center datatable" id="products_cart">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Cantidad Disponible</th>
                                            <th class="text-center">Precio</th>
                                            <th class="text-center">Agregar al Carrito</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->code }}</td>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">${{ $item->sale_price }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('sales.add-cart', $item->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fa-solid fa-cart-plus me-1"></i>Agregar
                                                    </a>
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

        <!-- Sección del carrito de compras -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            <h5 class="card-title mb-3">Carrito de compras</h5>

                            @if (session('items_cart'))
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle text-center">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>Total</th>
                                                <th>Quitar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $totalGeneral = 0; @endphp
                                            @foreach (session('items_cart') as $item)
                                                @php
                                                    $totalProduct = $item['quantity'] * $item['sale_price'];
                                                    $totalGeneral += $totalProduct;
                                                @endphp
                                                <tr>
                                                    <td>{{ $item['code'] }}</td>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>${{ $item['sale_price'] }}</td>
                                                    <td>${{ $totalProduct }}</td>
                                                    <td>
                                                        <a href="{{ route('sales.remove-cart', $item['id']) }}"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="fa-solid fa-trash-can me-1"></i>Quitar
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Total General:</td>
                                                <td colspan="3" class="text-center fw-bold">${{ $totalGeneral }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <form id="form_sale_submit" action="{{ route('sales.store-sale') }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary">
                                            <i class="fa-solid fa-check me-1"></i>Realizar Venta
                                        </button>
                                    </form>

                                    <a href="{{ route('sales.delete-cart') }}" class="btn btn-danger"><i
                                            class="fa-solid fa-trash me-1"></i>Borrar Carrito</a>
                                </div>
                            @else
                                <p class="text-center text-muted py-3">
                                    <i class="fa-solid fa-circle-info me-1"></i>No hay productos en el carrito.
                                </p>
                            @endif

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
            // Inicializar DataTable solo si no ha sido inicializado antes
            if (!$.fn.DataTable.isDataTable('#products_cart')) {
                $('#products_cart').DataTable({
                    pageLength: 5,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                        "infoFiltered": "(Filtrado de _MAX_ total registros)",
                        "lengthMenu": "Mostrar _MENU_ registros",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "No se encontraron resultados",
                        "paginate": {
                            "first": "<<",
                            "last": ">>",
                            "next": ">",
                            "previous": "<"
                        }
                    }
                });
            }
        });
    </script>

    <script>
        (function() {
            const $search = $('#customer_search');
            const $btnSearch = $('#btn_search_customer');
            const $results = $('#customer_results');
            const $card = $('#customer_selected_card');
            const $cid = $('#customer_id');

            let locked = false; // <- bloquea nuevas búsquedas cuando hay cliente seleccionado
            let debounceTimer = null;

            const lockSearch = () => {
                locked = true;
                $search.prop('disabled', true).addClass('bg-light');
                $btnSearch.prop('disabled', true);
                $results.hide().empty();
            };

            const unlockSearch = () => {
                locked = false;
                $search.prop('disabled', false).removeClass('bg-light').val('');
                $btnSearch.prop('disabled', false);
                $results.hide().empty();
                $search.focus();
            };

            const setSelected = (c) => {
                $('#c_full_name').text(c.full_name || '');
                $('#c_id_type').text((c.id_type || '').toUpperCase());
                $('#c_identification').text(c.identification || '');
                $('#c_phone').text(c.phone || '—');
                $('#c_email').text(c.email || '—');
                $('#c_address').text([c.city, c.canton, c.province, c.address].filter(Boolean).join(' • '));

                $cid.val(c.id);
                $card.show();

                // bloquear nuevas búsquedas
                lockSearch();

                // mostrar en el input lo elegido (solo lectura visual)
                $search.val(`${c.identification} - ${c.full_name}`);
            };

            const clearSelected = () => {
                $cid.val('');
                $card.hide();
                // permitir buscar de nuevo
                unlockSearch();
            };

            $('#btn_clear_customer').on('click', function() {
                clearSelected();
            });

            const renderResults = (items) => {
                if (!items.length) {
                    $results.html('<li class="list-group-item text-muted">Sin resultados</li>').show();
                    return;
                }
                const html = items.map(c => `
        <li class="list-group-item list-group-item-action" role="button"
            data-id="${c.id}"
            data-full_name="${c.full_name || ''}"
            data-id_type="${c.id_type || ''}"
            data-identification="${c.identification || ''}"
            data-phone="${c.phone || ''}"
            data-email="${c.email || ''}"
            data-city="${c.city || ''}"
            data-canton="${c.canton || ''}"
            data-province="${c.province || ''}"
            data-address="${c.address || ''}">
          <div class="d-flex justify-content-between">
            <span>
              <strong>${c.full_name || ''}</strong>
              <span class="text-muted small"> — ${(c.id_type || '')}: ${c.identification || ''}</span>
            </span>
            <span class="small text-muted">${c.email || ''}</span>
          </div>
        </li>
      `).join('');
                $results.html(html).show();
            };

            const doSearch = () => {
                if (locked) return; // <- no permitir búsquedas si ya hay cliente seleccionado

                const q = $search.val().trim();
                if (!q) {
                    $results.hide().empty();
                    return;
                }

                $.get(`{{ route('customers.search') }}`, {
                        q
                    })
                    .done(renderResults)
                    .fail(() => {
                        $results.html('<li class="list-group-item text-danger">Error buscando clientes.</li>')
                            .show();
                    });
            };

            // Buscar con click en lupa (si no está bloqueado)
            $btnSearch.on('click', function() {
                if (locked) return;
                doSearch();
            });

            // Buscar con debounce al tipear (si no está bloqueado)
            $search.on('keyup', function() {
                if (locked) return;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(doSearch, 300);
            });

            // Click en resultado => seleccionar y bloquear
            $results.on('click', 'li', function() {
                const $li = $(this);
                const c = {
                    id: $li.data('id'),
                    full_name: $li.data('full_name'),
                    id_type: $li.data('id_type'),
                    identification: $li.data('identification'),
                    phone: $li.data('phone'),
                    email: $li.data('email'),
                    city: $li.data('city'),
                    canton: $li.data('canton'),
                    province: $li.data('province'),
                    address: $li.data('address'),
                };
                setSelected(c);
                $results.hide().empty();
            });

            // Evitar enviar la venta sin cliente
            $('#form_sale_submit').on('submit', function(e) {
                if (!$cid.val()) {
                    e.preventDefault();
                    alert('Selecciona un cliente antes de realizar la venta.');
                }
            });

            // === Crear Cliente (AJAX) ===
            // === Crear Cliente (AJAX) con delegación ===
            $(document).on('submit', '#form_create_customer', function(e) {
                e.preventDefault();

                const $form = $(this);
                const data = $form.serialize();
                const $btn = $form.find('button[type="submit"]');

                $('#create_customer_alert').addClass('d-none').empty();
                $btn.prop('disabled', true);

                $.ajax({
                        url: `{{ route('customers.store') }}`,
                        method: 'POST',
                        data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .done(function() {
                        const identification = $form.find('[name="identification"]').val();

                        $.get(`{{ route('customers.search') }}`, {
                                q: identification
                            })
                            .done(function(items) {
                                if (items && items.length) {
                                    // Reutiliza tu setSelected(c) y bloqueo de búsqueda
                                    setSelected(items[0]);
                                    $('#customer_search').val(
                                        `${items[0].identification} - ${items[0].full_name}`);
                                }

                                // Limpiar y cerrar modal
                                $form[0].reset();
                                $('#create_customer_alert').addClass('d-none').empty();
                                const modalEl = document.getElementById('modalCreateCustomer');
                                bootstrap.Modal.getInstance(modalEl).hide();
                            });
                    })
                    .fail(function(xhr) {
                        let msg = 'Error al crear el cliente.';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        } else if (xhr.status === 419) {
                            msg = 'La sesión expiró. Recarga la página e inténtalo nuevamente.';
                        }
                        $('#create_customer_alert').removeClass('d-none').html(msg);
                    })
                    .always(function() {
                        $btn.prop('disabled', false);
                    });
            });
        })();
    </script>



    <style>
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-primary,
        .btn-success,
        .btn-danger {
            font-weight: 500;
            border-radius: 0.4rem;
            padding: 0.45rem 0.9rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .btn-primary:hover,
        .btn-success:hover,
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
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

    <!-- Modal: Crear Cliente -->
    <div class="modal fade" id="modalCreateCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="form_create_customer">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">

                        <div id="create_customer_alert" class="alert alert-danger d-none"></div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tipo</label>
                                <select name="id_type" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEDULA">CÉDULA</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Identificación</label>
                                <input type="text" name="identification" class="form-control" required
                                    maxlength="25">
                                <div class="form-text text-danger small d-none" id="id_exists_help">Ya existe un cliente
                                    con ese tipo y número de identificación.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" name="full_name" class="form-control" required maxlength="150">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="phone" class="form-control" maxlength="30">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Correo</label>
                                <input type="email" name="email" class="form-control" maxlength="150">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Código Postal</label>
                                <input type="text" name="postal_code" class="form-control" maxlength="20">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ciudad</label>
                                <input type="text" name="city" class="form-control" maxlength="100">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cantón</label>
                                <input type="text" name="canton" class="form-control" maxlength="100">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Provincia</label>
                                <input type="text" name="province" class="form-control" maxlength="100">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="address" class="form-control" maxlength="255">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save me-1"></i>Guardar y usar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
