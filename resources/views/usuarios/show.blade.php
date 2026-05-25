@extends('layouts.app')

@section('title', 'Mis Reservas')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Mis Reservas</h1>
            <p class="text-muted">Bienvenido, <strong>{{ $usuario->nombre }}</strong></p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('reservas.create') }}" class="btn btn-success">
                Nueva Reserva
            </a>
        </div>
    </div>

    @if($reservas->count() > 0)
        <div class="row">
            @foreach($reservas as $reserva)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header @if($reserva->estado == 'confirmada') bg-success @else bg-danger @endif text-white">
                            <h5 class="mb-0">{{ $reserva->cancha->nombre }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Fecha:</strong> 
                                {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}
                            </p>
                            <p class="mb-2">
                                <strong>Horario:</strong> 
                                {{ $reserva->horario->hora_inicio }} - {{ $reserva->horario->hora_fin }}
                            </p>
                            <p class="mb-2">
                                <strong>Jugadores:</strong> 
                                {{ $reserva->cantidad_jugadores }}
                            </p>
                            <p class="mb-2">
                                <strong>Precio:</strong> 
                                <span class="text-success">${{ number_format($reserva->horario->precio) }}</span>
                            </p>
                            <p class="mb-3">
                                <strong>Estado:</strong> 
                                @if($reserva->estado == 'confirmada')
                                    <span class="badge bg-success">Confirmada</span>
                                @elseif($reserva->estado == 'cancelada')
                                    <span class="badge bg-danger">Cancelada</span>
                                @endif
                            </p>
                        </div>
                        <div class="card-footer bg-light">
                            <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-sm btn-primary">
                                Ver Detalles
                            </a>
                            @if($reserva->estado == 'confirmada')
                                <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Deseas cancelar esta reserva?')">
                                        Cancelar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <h5>No tienes reservas aún</h5>
            <p>Haz clic en el botón "Nueva Reserva" para comenzar</p>
        </div>
    @endif
@endsection