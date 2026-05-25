@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Editar Usuario: {{ $usuario->nombre }}</h1>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="numero" class="form-label">Teléfono</label>
                            <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                   id="numero" name="numero" value="{{ old('numero', $usuario->numero) }}" required>
                            @error('numero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento</label>
                            <input type="text" class="form-control @error('documento') is-invalid @enderror" 
                                   id="documento" name="documento" value="{{ old('documento', $usuario->documento) }}" required>
                            @error('documento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                Guardar Cambios
                            </button>
                            <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection