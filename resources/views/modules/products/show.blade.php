@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar Productos</h1>
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
                            <h5 class="card-title">Eliminar Producto</h5>
                            <p>Una vez que el producto sea eliminado, no podra ser recuperado!!!</p>

                            <!-- Table with stripped rows -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Proveedor</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Imagen</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Venta</th>
                                        <th class="text-center">Compra</th>
                                        <th class="text-center">Activo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>{{ $items->name_category }}</td>
                                        <td>{{ $items->name_provider }}</td>
                                        <td>{{ $items->name }}</td>
                                        <td></td>
                                        <td>{{ $items->description }}</td>
                                        <td>{{ $items->quantity }}</td>
                                        <td>{{ $items->shopping_price }}</td>
                                        <td>{{ $items->sale_price }}</td>
                                        <td>
                                            <!-- $item->active -->
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="{{ $items->id }}"
                                                    {{ $items->active ? 'checked' : '' }}>
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                            <!-- End Table with stripped rows -->
                            <hr>
                            <form action="{{ route('products.destroy', $items->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Eliminar producto</button>
                                <a href="{{ route('products.index') }}" class="btn btn-info">Cancelar</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
