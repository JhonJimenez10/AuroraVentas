@extends('layouts.main')
@section('title', $title)

@section('content')
    {{-- flashes --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Agregar Clientes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Agregar Nuevo Cliente</h5>

                            <form action="{{ route('customers.store') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="id_type" class="form-label">Tipo de Identificación</label>
                                        <select name="id_type" id="id_type" class="form-select" required>
                                            <option value="" disabled {{ old('id_type') ? '' : 'selected' }}>
                                                Seleccione...</option>
                                            <option value="RUC" {{ old('id_type') == 'RUC' ? 'selected' : '' }}>RUC
                                            </option>
                                            <option value="CEDULA" {{ old('id_type') == 'CEDULA' ? 'selected' : '' }}>CÉDULA
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="identification" class="form-label">Identificación</label>
                                        <input type="text"
                                            class="form-control @error('identification') is-invalid @enderror" required
                                            name="identification" id="identification"
                                            value="{{ old('identification', $customer->identification ?? '') }}">
                                        @error('identification')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <label for="full_name" class="form-label">Nombre completo</label>
                                        <input type="text" class="form-control" required name="full_name" id="full_name"
                                            value="{{ old('full_name') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" required name="phone" id="phone"
                                            value="{{ old('phone') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Correo</label>
                                        <input type="email" class="form-control" required name="email" id="email"
                                            value="{{ old('email') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="postal_code" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" required name="postal_code"
                                            id="postal_code" value="{{ old('postal_code') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="city" class="form-label">Ciudad</label>
                                        <input type="text" class="form-control" required name="city" id="city"
                                            value="{{ old('city') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="canton" class="form-label">Cantón</label>
                                        <input type="text" class="form-control" required name="canton" id="canton"
                                            value="{{ old('canton') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="province" class="form-label">Provincia</label>
                                        <input type="text" class="form-control" required name="province" id="province"
                                            value="{{ old('province') }}">
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" required name="address" id="address"
                                            value="{{ old('address') }}">
                                    </div>
                                </div>

                                <button class="btn btn-primary mt-3">Guardar</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
