@extends('layouts.main')
@section('title', $title)

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Eliminar Categorias</h1>
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
              <h5 class="card-title"¿Estas seguro de eliminar esta categoria?</h5>
             
              <form action="{{ route ("categories.destroy", $item->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <label for="name">Nombre de categoria</label>
                <input type="text" class="form-control" readonly name = "name" id="name" value="{{ $item->name }}">
                <button class="btn btn-danger mt-3">Eliminar</button>
                <a href="{{route("categories.index")}}" class="btn btn-info mt-3">Cancelar</a>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
@endsection

