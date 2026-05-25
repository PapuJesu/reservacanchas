@extends('layouts.app')

@section('title', 'Panel Admin - Canchas')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4"> Panel de Administración - Canchas</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('admin.canchas.create') }}" class="btn btn-primary">
                Crear Nueva Cancha
            </a>
            <a href="{{ route('admin.reservas') }}" class="btn btn-info">
                Ver Reservas
            </a>
            <a href="{{ route('admin.usuarios') }}" class="btn btn-warning">
                Gestionar Usuarios
            </a>
        </div>
    </div>

    @if($canchas->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Horarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($canchas as $cancha)
                        <tr>
                            <td><strong>{{ $cancha->nombre }}</strong></td>
                            <td>{{ $cancha->direccion }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $cancha->horarios->count() }} horarios
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.canchas.edit', $cancha->id) }}" class="btn btn-sm btn-warning">
                                    ✏️ Editar
                                </a>
                                <a href="{{ route('admin.horarios', $cancha->id) }}" class="btn btn-sm btn-info">
                                    ⏰ Horarios
                                </a>
                                <form action="{{ route('admin.canchas.destroy', $cancha->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Eliminar esta cancha?')">
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
            No hay canchas creadas. <a href="{{ route('admin.canchas.create') }}">Crear una ahora</a>
        </div>
    @endif
@endsection