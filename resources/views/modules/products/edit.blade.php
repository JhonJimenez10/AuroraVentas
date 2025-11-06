@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Editar Producto</h1>
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
                            <h5 class="card-title">Editar Producto</h5>

                            <form action="{{ route('products.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label for="category_id">Categoria</label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="">Selecciona una categoria</option>
                                    @foreach ($categories as $category)
                                        @if ($item->category_id == $category->id)
                                            <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <label for="provider_id">Proveedor</label>
                                <select name="provider_id" id="provider_id" class="form-select" required>
                                    <option value="">Selecciona un proveedor</option>
                                    @foreach ($providers as $provider)
                                        @if ($item->provider_id == $provider->id)
                                            <option selected value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @else
                                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <label for="code">Código</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ $item->code }}">

                                <label for="name">Nombre del producto</label>
                                <input type="text" class="form-control" required name = "name" id="name"
                                    value="{{ $item->name }}">
                                <label for="description">Descripción</label>
                                <textarea cols="20" rows="5" class="form-control" name="description" id="description">{{ $item->description }}</textarea>
                                <label for="sale_price">Precio de venta</label>
                                <input type="text" id="sale_price" name="sale_price" class="form-control"
                                    value="{{ $item->sale_price }}" required>
                                <button class="btn
                                    btn-warning mt-3">Actualizar</button>
                                <a href="{{ route('products.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
