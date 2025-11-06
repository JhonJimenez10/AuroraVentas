<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Ticket de venta {{ $sale->id }}</title>
    <style>
        /* ====== Base ====== */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 12px;
            color: #000;
        }

        .clearfix {
            clear: both;
        }

        /* ====== Cabecera ====== */
        .header-container {
            margin-bottom: 8px;
            position: relative;
        }

        .box {
            float: left;
            width: 48%;
            margin-right: 4%;
            border: 1px solid #000;
            border-radius: 8px;
            padding: 8px;
            box-sizing: border-box;
            min-height: 120px;
        }

        .box:last-of-type {
            margin-right: 0;
        }

        .box table {
            width: 100%;
            border-collapse: collapse;
        }

        .box td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .box td.label {
            font-weight: bold;
            text-transform: uppercase;
            width: 42%;
            white-space: nowrap;
        }

        .header-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 6px 0;
            line-height: 1.2;
        }

        .subtitle {
            text-align: center;
            font-size: 10px;
            margin: 0 0 8px 0;
        }

        /* ====== Cliente ====== */
        .client-box {
            clear: both;
            border: 1px solid #000;
            border-radius: 6px;
            padding: 6px;
            margin: 8px 0;
        }

        .client-box p {
            margin: 3px 0;
        }

        .client-box strong {
            font-weight: bold;
        }

        .client-box .info-line {
            white-space: nowrap;
        }

        .client-box .info-item {
            display: inline-block;
            margin-right: 40px;
        }

        /* ====== Detalle ====== */
        .invoice-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .invoice-details th,
        .invoice-details td {
            border: 1px solid #000;
            padding: 4px;
        }

        .invoice-details th {
            background: #f0f0f0;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        /* ====== Totales ====== */
        .totals-box {
            width: 40%;
            margin-left: auto;
            margin-top: 8px;
        }

        .totals {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            border: 1px solid #000;
            padding: 4px;
            text-align: right;
        }

        .totals td:first-child {
            text-align: left;
            font-weight: bold;
            width: 60%;
        }

        /* ====== Pie ====== */
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>

<body>

    {{-- Título / Encabezado --}}
    <div class="header-title">COMPROBANTE DE VENTA</div>
    <div class="subtitle">Documento no válido como factura</div>

    {{-- Cabecera: Izquierda (Negocio / Venta) --}}
    <div class="header-container">
        <div class="box">
            <table>
                <tr>
                    <td colspan="2" style="font-weight:bold; font-size:12px;">
                        {{ config('app.name') ?? 'Mi Negocio' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label">Dirección:</td>
                    <td>{{ $sale->enterprise_address ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Teléfono:</td>
                    <td>{{ $sale->enterprise_phone ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Atendido por:</td>
                    <td>{{ $sale->user_name }}</td>
                </tr>
                <tr>
                    <td class="label">Fecha:</td>
                    <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        {{-- Cabecera: Derecha (Datos del Comprobante) --}}
        <div class="box">
            <table>
                <tr>
                    <td class="label">Tipo:</td>
                    <td>TICKET</td>
                </tr>
                <tr>
                    <td class="label">N°:</td>
                    <td>{{ str_pad($sale->id, 8, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td class="label">Estado:</td>
                    <td>EMITIDO</td>
                </tr>
                <tr>
                    <td class="label">Moneda:</td>
                    <td>USD</td>
                </tr>
                <tr>
                    <td class="label">Total:</td>
                    <td><strong>${{ number_format($sale->total_sale, 2) }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>

    {{-- Cliente --}}
    <div class="client-box">
        <p><strong>Cliente:</strong> {{ $sale->customer_full_name ?? '—' }}</p>
        <p class="info-line">
            <span class="info-item"><strong>Tipo Doc.:</strong> {{ $sale->customer_id_type ?? '—' }}</span>
            <span class="info-item"><strong>Identificación:</strong> {{ $sale->customer_identification ?? '—' }}</span>
        </p>
        <p class="info-line">
            <span class="info-item"><strong>Teléfono:</strong> {{ $sale->customer_phone ?? '—' }}</span>
            <span class="info-item"><strong>Correo:</strong> {{ $sale->customer_email ?? '—' }}</span>
        </p>
        <p><strong>Dirección:</strong>
            {{ collect([$sale->customer_city ?? null, $sale->customer_canton ?? null, $sale->customer_province ?? null, $sale->customer_address ?? null])->filter()->implode(' • ') ?:'—' }}
        </p>
    </div>

    {{-- Detalle --}}
    <table class="invoice-details">
        <thead>
            <tr>
                <th>Producto</th>
                <th style="width: 12%;">Cantidad</th>
                <th style="width: 18%;">Precio U.</th>
                <th style="width: 18%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach ($details as $line)
                @php
                    $lineSubtotal = (float) $line->unit_price * (float) $line->quantity;
                    $subtotal += $lineSubtotal;
                @endphp
                <tr>
                    <td class="text-left">{{ $line->product_name }}</td>
                    <td class="text-right">{{ number_format($line->quantity, 0) }}</td>
                    <td class="text-right">{{ number_format($line->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($lineSubtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totales --}}
    <div class="totals-box">
        <table class="totals">
            <tr>
                <td>SUBTOTAL</td>
                <td>{{ number_format($subtotal, 2) }}</td>
            </tr>
            {{-- Si en el futuro manejas impuestos/desc., agrégalos aquí --}}
            {{-- <tr><td>DESCUENTO</td><td>0.00</td></tr> --}}
            {{-- <tr><td>IVA</td><td>0.00</td></tr> --}}
            <tr>
                <td><strong>TOTAL</strong></td>
                <td><strong>{{ number_format($sale->total_sale, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    {{-- Pie --}}
    <div class="footer">
        ¡Gracias por su compra!
    </div>

</body>

</html>
