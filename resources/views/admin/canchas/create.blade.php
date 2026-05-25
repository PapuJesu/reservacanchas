@extends('layouts.app')

@section('title', 'Crear Cancha')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">➕ Crear Nueva Cancha</h1>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.canchas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Cancha</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                                   id="direccion" name="direccion" value="{{ old('direccion') }}" required>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="latitud" class="form-label">Latitud (opcional)</label>
                            <input type="text" class="form-control @error('latitud') is-invalid @enderror" 
                                id="latitud" name="latitud" value="{{ old('latitud') }}" placeholder="Ej: 10.9885">
                            @error('latitud')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="longitud" class="form-label">Longitud (opcional)</label>
                            <input type="text" class="form-control @error('longitud') is-invalid @enderror" 
                                id="longitud" name="longitud" value="{{ old('longitud') }}" placeholder="Ej: -74.7883">
                            @error('longitud')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="embed_maps" class="form-label">Embed de Google Maps</label>
                            <textarea class="form-control @error('embed_maps') is-invalid @enderror" 
                                    id="embed_maps" name="embed_maps" rows="3">{{ old('embed_maps') }}</textarea>
                            <small class="text-muted">
                                Pega aquí el código embed de Google Maps. 
                                <a href="https://www.google.com/maps" target="_blank">Ir a Google Maps</a>
                            </small>
                            @error('embed_maps')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                        id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="(57) 3000000000">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email') }}" placeholder="info@cancha.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="informacion" class="form-label">Información General</label>
                            <textarea class="form-control @error('informacion') is-invalid @enderror" 
                                      id="informacion" name="informacion" rows="4" required>{{ old('informacion') }}</textarea>
                            <small class="text-muted">Descripción de la cancha, servicios, etc.</small>
                            @error('informacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reglas" class="form-label">Reglas de la Cancha</label>
                            <textarea class="form-control @error('reglas') is-invalid @enderror" 
                                      id="reglas" name="reglas" rows="4" required>{{ old('reglas') }}</textarea>
                            <small class="text-muted">Escribe cada regla en una línea nueva</small>
                            @error('reglas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fotos" class="form-label">Fotos de la Cancha</label>
                            <input type="file" class="form-control @error('fotos.*') is-invalid @enderror" 
                                   id="fotos" name="fotos[]" multiple accept="image/*">
                            <small class="text-muted">Puedes cargar múltiples fotos (máx 2MB cada una)</small>
                            @error('fotos.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                ✅ Crear Cancha
                            </button>
                            <a href="{{ route('admin.canchas.index') }}" class="btn btn-secondary">
                                ❌ Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection