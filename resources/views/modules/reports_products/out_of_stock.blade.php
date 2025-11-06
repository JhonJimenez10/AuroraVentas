@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Reportes Productos con Cantidad 1 o 0</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Productos</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reportes Productos</h5>
                            <p>Reportes del stock del sistema.</p>
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th class="text-start">Categoria</th>
                                        <th class="text-start">Proveedor</th>
                                        <th class="text-start">Nombre</th>
                                        <th class="text-start">Imagen</th>
                                        <th class="text-start">Descripción</th>
                                        <th class="text-start">Cantidad</th>
                                        <th class="text-start">Venta</th>
                                        <th class="text-start">Compra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->name_category }}</td>
                                            <td>{{ $item->name_provider }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $item->image_product) }}" alt=""
                                                    width="60px" height="60px">
                                            </td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ $item->shopping_price }}</td>
                                            <td>${{ $item->sale_price }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
