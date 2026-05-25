@extends('layouts.app')

@section('title', 'Crear Horario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">➕ Agregar Horario a: {{ $cancha->nombre }}</h1>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.horarios.store', $cancha->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="dia_semana" class="form-label">Día de la Semana</label>
                            <select class="form-select @error('dia_semana') is-invalid @enderror" 
                                    id="dia_semana" name="dia_semana" required>
                                <option value="">-- Elige un día --</option>
                                <option value="lunes" @if(old('dia_semana') == 'lunes') selected @endif>Lunes</option>
                                <option value="martes" @if(old('dia_semana') == 'martes') selected @endif>Martes</option>
                                <option value="miercoles" @if(old('dia_semana') == 'miercoles') selected @endif>Miércoles</option>
                                <option value="jueves" @if(old('dia_semana') == 'jueves') selected @endif>Jueves</option>
                                <option value="viernes" @if(old('dia_semana') == 'viernes') selected @endif>Viernes</option>
                                <option value="sabado" @if(old('dia_semana') == 'sabado') selected @endif>Sábado</option>
                                <option value="domingo" @if(old('dia_semana') == 'domingo') selected @endif>Domingo</option>
                            </select>
                            @error('dia_semana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" 
                                   id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio') }}" required>
                            @error('hora_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora de Fin</label>
                            <input type="time" class="form-control @error('hora_fin') is-invalid @enderror" 
                                   id="hora_fin" name="hora_fin" value="{{ old('hora_fin') }}" required>
                            @error('hora_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control @error('precio') is-invalid @enderror" 
                                   id="precio" name="precio" value="{{ old('precio') }}" min="1000" step="1000" required>
                            <small class="text-muted">En pesos colombianos</small>
                            @error('precio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                ✅ Crear Horario
                            </button>
                            <a href="{{ route('admin.horarios', $cancha->id) }}" class="btn btn-secondary">
                                ❌ Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection