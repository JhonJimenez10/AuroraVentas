@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Agregar Proveedor</h1>
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
                            <h5 class="card-title">Agregar Nuevo Proveedor</h5>

                            <form action="{{ route('providers.store') }}" method="POST">
                                @csrf
                                <label for="name">Nombre de proveedor</label>
                                <input type="text" class="form-control" required name = "name" id="name">
                                <label for="phone">Telefono</label>
                                <input type="text" class="form-control" required name = "phone" id="phone">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" required name = "email" id="email">
                                <label for="postal_code">Codigo Postal</label>
                                <input type="text" class="form-control" required name = "postal_code" id="postal_code">
                                <label for="address">Direccion</label>
                                <input type="text" class="form-control" required name = "address" id="address">
                                <label for="notes">Observacion</label>
                                <input type="text" class="form-control" name = "notes" id="notes">
                                <button class="btn btn-primary mt-3">Guardar</button>
                                <a href="{{ route('providers.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
