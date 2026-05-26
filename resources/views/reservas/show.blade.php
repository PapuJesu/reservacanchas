@extends('layouts.app')

@section('title', 'Detalle de Reserva')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Detalle de Reserva</h1>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Reserva #{{ $reserva->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Información del Usuario</h6>
                            <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
                            <p><strong>Teléfono:</strong> {{ $usuario->numero }}</p>
                            <p><strong>Documento:</strong> {{ $usuario->documento }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Información de la Reserva</h6>
                            <p><strong>Estado:</strong> 
                                @if($reserva->estado == 'confirmada')
                                    <span class="badge bg-success">Confirmada</span>
                                @elseif($reserva->estado == 'cancelada')
                                    <span class="badge bg-danger">Cancelada</span>
                                @endif
                            </p>
                            <p><strong>Fecha de Creación:</strong> {{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Detalles de la Cancha</h6>
                            <p><strong>Cancha:</strong> {{ $cancha->nombre }}</p>
                            <p><strong>Dirección:</strong> {{ $cancha->direccion }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Detalles de la Reserva</h6>
                            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</p>
                            <p><strong>Horario:</strong> {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</p>
                            <p><strong>Cantidad de Jugadores:</strong> {{ $reserva->cantidad_jugadores }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted">Precio</h6>
                            <h4 class="text-success">${{ number_format($horario->precio) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('usuarios.show', session('usuario_id')) }}" class="btn btn-secondary">
                    Volver a Mis Reservas
                </a>
                <a href="{{ route('reservas.pdf', $reserva->id) }}" class="btn btn-primary">
                    Descargar PDF Oficial
                </a>
            </div>

            @if($reserva->estado == 'confirmada')
                <div class="card border-danger">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Cancelar Reserva</h5>
                        <p class="text-muted">¿Deseas cancelar esta reserva?</p>
                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                Cancelar Reserva
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection