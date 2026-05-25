@extends('layouts.app')

@section('title', 'Panel Admin - Reservas')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Gestión de Reservas</h1>
        </div>
    </div>

    <!-- Filtro por cancha -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.reservas') }}" class="d-flex gap-2">
                <select name="cancha_id" class="form-select" style="max-width: 300px;">
                    <option value="">Todas las canchas</option>
                    @foreach($canchas as $cancha)
                        <option value="{{ $cancha->id }}" @if($cancha_id == $cancha->id) selected @endif>
                            {{ $cancha->nombre }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.reservas') }}" class="btn btn-secondary">Limpiar</a>
            </form>
        </div>
    </div>

    <!-- Tabla de reservas -->
    @if($reservas->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Cancha</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Jugadores</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $reserva)
                        <tr>
                            <td>#{{ $reserva->id }}</td>
                            <td>{{ $reserva->usuario->nombre }}</td>
                            <td>{{ $reserva->cancha->nombre }}</td>
                            <td>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $reserva->horario->hora_inicio }} - {{ $reserva->horario->hora_fin }}</td>
                            <td>{{ $reserva->cantidad_jugadores }}</td>
                            <td>
                                @if($reserva->estado == 'confirmada')
                                    <span class="badge bg-success">Confirmada</span>
                                @else
                                    <span class="badge bg-danger">Cancelada</span>
                                @endif
                            </td>
                            <td>
                                @if($reserva->estado == 'confirmada')
                                    <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('¿Cancelar esta reserva?')">
                                            Cancelar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            No hay reservas registradas
        </div>
    @endif

    <a href="{{ route('admin.canchas.index') }}" class="btn btn-secondary mt-4">
        Volver
    </a>
@endsection