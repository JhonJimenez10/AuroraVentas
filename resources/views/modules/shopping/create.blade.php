@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Hacer Compra</h1>
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
                            <h5 class="card-title">Nueva compra de : {{ $item->name }}</h5>

                            <form action="{{ route('shopping.store') }}" method="POST">
                                @csrf
                                <input type="text" value="{{ $item->id }}" id="id" name="id" hidden>
                                <label for="quantity">Cantidad del producto</label>
                                <input type="text" class="form-control" required name = "quantity" id="quantity">
                                <label for="shopping_price">Precio unitario</label>
                                <input type="text" id="shopping_price" name="shopping_price" class="form-control"
                                    required>
                                <button class="btn btn-primary mt-3">Comprar</button>
                                <a href="{{ route('products.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
