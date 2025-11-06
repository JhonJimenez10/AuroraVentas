@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Agregar Producto</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Productos</a></li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Agregar Nuevo Producto</h5>

                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="category_id">Categoria</label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="">Selecciona una categoria</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                <label for="provider_id">Proveedor</label>
                                <select name="provider_id" id="provider_id" class="form-select" required>
                                    <option value="">Selecciona un proveedor</option>
                                    @foreach ($providers as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <label for="code">Código</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                                <label for="name">Nombre del producto</label>
                                <input type="text" class="form-control" required name = "name" id="name">
                                <label for="description">Descripción</label>
                                <textarea cols="20" rows="5" class="form-control" name="description" id="description"></textarea>
                                <label for="image">Imagen</label>
                                <input type="file" id="image" name="image" class="form-control">
                                <button class="btn btn-primary mt-3">Guardar</button>
                                <a href="{{ route('products.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
