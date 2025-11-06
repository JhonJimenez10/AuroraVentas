@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Editar Compra</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Comprar</a></li>
                    <li class="breadcrumb-item active">Shopping</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edicion de : {{ $item->name_product }}</h5>

                            <form action="{{ route('shopping.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" id="product_id" name="product_id" value="{{ $item->product_id }}"
                                    hidden>
                                <input type="text" value="{{ $item->id }}" id="id" name="id" hidden>
                                <label for="quantity">Cantidad del producto</label>
                                <input type="text" class="form-control" required name = "quantity" id="quantity"
                                    value="{{ $item->quantity }}">
                                <label for="shopping_price">Precio de compra</label>
                                <input type="text" id="shopping_price" name="shopping_price" class="form-control"
                                    required value="{{ $item->shopping_price }}">
                                <button class="btn btn-warning mt-3">Actualizar</button>
                                <a href="{{ route('shopping.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
