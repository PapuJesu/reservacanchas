@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Canchas Disponibles</h1>
        </div>
    </div>

    <div class="row">
        @forelse($canchas as $cancha)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @php
                        $fotos = json_decode($cancha->fotos, true) ?? [];
                        $primeraFoto = $fotos[0] ?? null;
                    @endphp
                    
                    @if($primeraFoto)
                        <img src="{{ asset('storage/' . $primeraFoto) }}" class="card-img-top" alt="{{ $cancha->nombre }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top" style="height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            Sin imagen
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $cancha->nombre }}</h5>
                        <p class="card-text text-muted">
                            {{ $cancha->direccion }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('canchas.show', $cancha->id) }}" class="btn btn-primary w-100">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info">No hay canchas disponibles</div>
            </div>
        @endforelse
    </div>
@endsection