@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar compra de productos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Compras</a></li>
                    <li class="breadcrumb-item active">Shopping</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Eliminar compra</h5>
                            <p>Una vez eleiminada la compra, no podra ser recuperada.</p>

                            <!-- Table with stripped rows -->


                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Usuario</th>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Precio de compra</th>
                                        <th class="text-center">Total de compra</th>
                                        <th class="text-center">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>{{ $items->name_user }}</td>
                                        <td>{{ $items->name_product }}</td>
                                        <td>{{ $items->quantity }}</td>
                                        <td>${{ $items->shopping_price }}</td>
                                        <td>${{ $items->shopping_price * $items->quantity }}</td>
                                        <td>{{ $items->created_at }}</td>
                                    </tr>

                                </tbody>
                            </table>
                            <hr>
                            <form action="{{ route('shopping.destroy', $items->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="text" value="{{ $items->product_id }}" name="product_id" hidden>
                                <button class="btn btn-danger mt-3">Eliminar Compra</button>
                                <a href="{{ route('shopping.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
