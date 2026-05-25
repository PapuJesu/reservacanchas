@extends('layouts.app')

@section('title', 'Horarios - ' . $cancha->nombre)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">⏰ Horarios de: {{ $cancha->nombre }}</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('admin.horarios.create', $cancha->id) }}" class="btn btn-primary">
                ➕ Agregar Horario
            </a>
            <a href="{{ route('admin.canchas.index') }}" class="btn btn-secondary">
                ← Volver a Canchas
            </a>
        </div>
    </div>

    @if($horarios->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $horario)
                    <tr>
                        <td><strong>{{ ucfirst($horario->dia_semana) }}</strong></td>
                        <td>{{ $horario->hora_inicio }}</td>
                        <td>{{ $horario->hora_fin }}</td>
                        <td><strong>${{ number_format($horario->precio) }}</strong></td>
                        <td>
                            <form action="{{ route('admin.horarios.destroy', $horario->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('¿Eliminar este horario?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-info">
        No hay horarios para esta cancha. <a href="{{ route('admin.horarios.create', $cancha->id) }}">Crear uno ahora</a>
    </div>
@endif
@endsection