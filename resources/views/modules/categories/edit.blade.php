@extends('layouts.main')
@section('title', $title)

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Editar Categorias</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Categorias</a></li>
          <li class="breadcrumb-item active">Categories</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Editar Categoria</h5>
             
              <form action="{{ route ("categories.update", $item->id)}}" method="POST">
                @csrf
                @method('PUT')
                <label for="name">Nombre de categoria</label>
                <input type="text" class="form-control" required name = "name" id="name" value="{{ $item->name }}">
                <button class="btn btn-warning mt-3">Actualizar</button>
                <a href="{{route("categories.index")}}" class="btn btn-info mt-3">Cancelar</a>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
@endsection

