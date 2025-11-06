@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar Proveedor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Proveedores</a></li>
                    <li class="breadcrumb-item active">Providers</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">¿Estas seguro de eliminar el proveedor?</h5>
                            <p>Una vez eliminado el proveedor no podra ser recuperado.</p>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Telefono</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Codigo Postal</th>
                                        <th class="text-center">Direccion</th>
                                        <th class="text-center">Observacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->postal_code }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->notes }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <form action="{{ route('providers.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger mt-3">Eliminar proveedor</button>
                                <a href="{{ route('providers.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>

                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
