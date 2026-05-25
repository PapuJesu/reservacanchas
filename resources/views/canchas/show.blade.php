@extends('layouts.app')

@section('title', $cancha->nombre)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">{{ $cancha->nombre }}</h1>
        </div>
    </div>

    <!-- CARRUSEL DE FOTOS -->
    <div class="row mb-5">
        <div class="col-md-8">
            <div id="carouselCancha" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if($cancha->fotos)
                        @php
                            $fotos = json_decode($cancha->fotos, true) ?? [];
                        @endphp
                        @forelse($fotos as $index => $foto)
                            <div class="carousel-item @if($index === 0) active @endif">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $index + 1 }}" 
                                     style="width: 100%; height: 400px; object-fit: cover;">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <div style="height: 400px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 18px;">
                                    Sin fotos disponibles
                                </div>
                            </div>
                        @endforelse
                    @else
                        <div class="carousel-item active">
                            <div style="height: 400px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 18px;">
                                Sin fotos disponibles
                            </div>
                        </div>
                    @endif
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCancha" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselCancha" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card sticky-top">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ $cancha->nombre }}</h5>
                    <p class="mb-2"><strong>Dirección</strong></p>
                    <p class="mb-4">{{ $cancha->direccion }}</p>
                    
                    <p class="mb-2"><strong>Horarios</strong></p>
                    <p class="mb-4">{{ $horarios->count() }} disponibles</p>

                    @if(session()->has('usuario_id'))
                        <a href="{{ route('reservas.create', ['cancha_id' => $cancha->id]) }}" class="btn btn-primary w-100">
                            Reservar Ahora
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                            Iniciar Sesión
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="row mb-5">
        <div class="col-md-8">
            <!-- INFORMACIÓN GENERAL -->
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Información General</h5>
                </div>
                <div class="card-body">
                    <p>{{ $cancha->informacion ?? 'No hay información disponible' }}</p>
                </div>
            </div>

            <!-- REGLAS -->
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Reglas de la Cancha</h5>
                </div>
                <div class="card-body">
                    @if($cancha->reglas)
                        <ul class="mb-0">
                            @foreach(explode("\n", $cancha->reglas) as $regla)
                                @if(trim($regla))
                                    <li>{{ trim($regla) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No hay reglas especificadas</p>
                    @endif
                </div>
            </div>

            <!-- HORARIOS -->
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Horarios Disponibles</h5>
                </div>
                <div class="card-body">
                    @if($horarios->count() > 0)
                        @php
                            $horariosPorDia = $horarios->groupBy('dia_semana');
                            $ordenDias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Día</th>
                                        <th>Hora Inicio</th>
                                        <th>Hora Fin</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ordenDias as $dia)
                                        @if(isset($horariosPorDia[$dia]))
                                            @foreach($horariosPorDia[$dia] as $horario)
                                                <tr>
                                                    <td><strong>{{ ucfirst($dia) }}</strong></td>
                                                    <td>{{ $horario->hora_inicio }}</td>
                                                    <td>{{ $horario->hora_fin }}</td>
                                                    <td>${{ number_format($horario->precio) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No hay horarios disponibles</p>
                    @endif
                </div>
            </div>

            <!-- TORNEOS -->
            @if($torneos->count() > 0)
                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="mb-0">Torneos</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($torneos as $torneo)
                                <div class="list-group-item">
                                    <h6 class="mb-0">{{ $torneo->nombre }}</h6>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- SIDEBAR -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Contacto</h5>
                </div>
                <div class="card-body">
                    @if($cancha->telefono)
                        <p class="mb-2"><strong>Teléfono:</strong><br> {{ $cancha->telefono }}</p>
                    @endif
                    @if($cancha->email)
                        <p class="mb-2"><strong>Email:</strong><br> {{ $cancha->email }}</p>
                    @endif
                    @if(!$cancha->telefono && !$cancha->email)
                        <p class="text-muted mb-0">No hay información de contacto disponible</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Ubicación</h5>
                </div>
                <div class="card-body p-0">
                    @if($cancha->embed_maps)
                        <div class="position-relative" style="overflow: hidden; border-radius: 0 0 0.25rem 0.25rem;">
                            {!! $cancha->embed_maps !!}
                        </div>
                    @else
                        <p class="text-muted p-3 mb-0">Mapa no disponible</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- BOTÓN FLOTANTE DE RESERVA -->
    @if(session()->has('usuario_id'))
        <div class="position-fixed bottom-0 end-0 p-4">
            <a href="{{ route('reservas.create', ['cancha_id' => $cancha->id]) }}" class="btn btn-primary btn-lg rounded-circle" 
               style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold;" 
               title="Realizar reserva">
                +
            </a>
        </div>
    @endif
@endsection