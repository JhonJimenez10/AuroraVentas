@extends('layouts.main')
@section('title', $title)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Editar imagen de producto</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Imagenes</a></li>
                    <li class="breadcrumb-item active">Images</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Editar imagen de producto</h5>



                            <hr>
                            <form action="{{ route('products.update.image', $item->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label for="image">Selecciona la nueva imagen</label>
                                <input type="file" name="image" id="image" class="form-control">
                                <hr>
                                <button class="btn btn-warning">Actualizar imagen</button>
                                <a href="{{ route('products.index') }}" class="btn btn-info">Cancelar</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
