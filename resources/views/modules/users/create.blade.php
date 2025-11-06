@extends('layouts.main')
@section('title', $title)

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Agregar Usuarios</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Usuarios</a></li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Agregar Nuevo Usuario</h5>
             
              <form action="{{ route("users.store")}}" method="POST">
                @csrf
                <label for="name">Nombre del usuario</label>
                <input type="text" class="form-control" required name = "name" id="name">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <label for="role">Rol de usuario</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">Selecciona el rol</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <button class="btn btn-primary mt-3">Guardar</button>
                <a href="{{route("users.index")}}" class="btn btn-info mt-3">Cancelar</a>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
@endsection

