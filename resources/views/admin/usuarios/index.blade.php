@extends('layouts.app')

@section('title', 'Panel Admin - Usuarios')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Gestión de Usuarios</h1>
        </div>
    </div>

    @if($usuarios->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Documento</th>
                        <th>Reservas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>#{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->numero }}</td>
                            <td>{{ $usuario->documento }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $usuario->reservas->count() }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Eliminar este usuario? Se eliminarán también sus reservas.')">
                                        Eliminar
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
            No hay usuarios registrados
        </div>
    @endif

    <a href="{{ route('admin.canchas.index') }}" class="btn btn-secondary mt-4">
        Volver
    </a>
@endsection