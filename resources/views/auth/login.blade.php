@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if(!$errors->any() || $errors->has('login')) active @endif" data-bs-toggle="tab" href="#login">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($errors->any() && !$errors->has('login')) active @endif" data-bs-toggle="tab" href="#registro">Registrarse</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- LOGIN -->
                <div id="login" class="tab-pane fade @if(!$errors->any() || $errors->has('login')) show active @endif">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Inicia Sesión</h5>

                            @if($errors->has('login'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('login') }}
                                </div>
                            @endif

                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="documento_login" class="form-label">Documento de Identidad</label>
                                    <input type="text" class="form-control @error('documento') is-invalid @enderror" 
                                           id="documento_login" name="documento" value="{{ old('documento') }}" required>
                                    @error('documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_login" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password_login" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- REGISTRO -->
                <div id="registro" class="tab-pane fade @if($errors->any() && !$errors->has('login')) show active @endif">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Crear Cuenta</h5>

                            <form action="{{ route('usuarios.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número de Teléfono</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                           id="numero" name="numero" value="{{ old('numero') }}" required>
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="documento_registro" class="form-label">Documento de Identidad</label>
                                    <input type="text" class="form-control @error('documento') is-invalid @enderror" 
                                           id="documento_registro" name="documento" value="{{ old('documento') }}" required>
                                    @error('documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_registro" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password_registro" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success w-100">Registrarse</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection