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
            <h1>Editar Cliente</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Editar Cliente</h5>

                            {{-- Nota: aquí uso $item para mantener el patrón de tus vistas de categorías --}}
                            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="id_type" class="form-label">Tipo de Identificación</label>
                                        <select name="id_type" id="id_type" class="form-select" required>
                                            <option value="RUC"
                                                {{ old('id_type', $customer->id_type) == 'RUC' ? 'selected' : '' }}>RUC
                                            </option>
                                            <option value="CEDULA"
                                                {{ old('id_type', $customer->id_type) == 'CEDULA' ? 'selected' : '' }}>
                                                CÉDULA</option>
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
                                            value="{{ old('full_name', $customer->full_name) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" name="phone" id="phone"
                                            value="{{ old('phone', $customer->phone) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Correo</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email', $customer->email) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="postal_code" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" name="postal_code" id="postal_code"
                                            value="{{ old('postal_code', $customer->postal_code) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="city" class="form-label">Ciudad</label>
                                        <input type="text" class="form-control" name="city" id="city"
                                            value="{{ old('city', $customer->city) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="canton" class="form-label">Cantón</label>
                                        <input type="text" class="form-control" name="canton" id="canton"
                                            value="{{ old('canton', $customer->canton) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="province" class="form-label">Provincia</label>
                                        <input type="text" class="form-control" name="province" id="province"
                                            value="{{ old('province', $customer->province) }}">
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" name="address" id="address"
                                            value="{{ old('address', $customer->address) }}">
                                    </div>
                                </div>

                                <button class="btn btn-warning mt-3">Actualizar</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-info mt-3">Cancelar</a>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
