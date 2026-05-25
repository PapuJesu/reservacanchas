@extends('layouts.app')

@section('title', 'Realizar Reserva')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Realizar Reserva</h1>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('reservas.store') }}" method="POST" id="reservaForm">
                        @csrf

                        <!-- PASO 1: Cancha -->
                        <div class="mb-3">
                            <label for="cancha_id" class="form-label">1. Selecciona una Cancha</label>
                            <select class="form-select @error('cancha_id') is-invalid @enderror" 
                                    id="cancha_id" name="cancha_id" required>
                                <option value="">-- Elige una cancha --</option>
                                @foreach($canchas as $cancha)
                                    <option value="{{ $cancha->id }}" data-cancha="{{ json_encode($cancha) }}">
                                        {{ $cancha->nombre }} - {{ $cancha->direccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cancha_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PASO 2: Fecha -->
                        <div class="mb-3" id="fechaContainer" style="display: none;">
                            <label for="fecha" class="form-label">2. Selecciona una Fecha</label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                   id="fecha" name="fecha" value="{{ old('fecha') }}">
                            @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PASO 3: Horario -->
                        <div class="mb-3" id="horarioContainer" style="display: none;">
                            <label for="horario_id" class="form-label">3. Selecciona un Horario</label>
                            <select class="form-select @error('horario_id') is-invalid @enderror" 
                                    id="horario_id" name="horario_id">
                                <option value="">-- Elige un horario --</option>
                            </select>
                            @error('horario_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="precioInfo" class="mt-2"></div>
                        </div>

                        <!-- PASO 4: Cantidad de Jugadores -->
                        <div class="mb-3" id="jugadoresContainer" style="display: none;">
                            <label for="cantidad_jugadores" class="form-label">4. Cantidad de Jugadores</label>
                            <input type="number" class="form-control @error('cantidad_jugadores') is-invalid @enderror" 
                                   id="cantidad_jugadores" name="cantidad_jugadores" min="1" max="11" 
                                   value="{{ old('cantidad_jugadores') }}">
                            <small class="text-muted">Mínimo 1, máximo 11 jugadores</small>
                            @error('cantidad_jugadores')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Usuario ID (oculto) -->
                        <input type="hidden" name="usuario_id" value="{{ session('usuario_id') }}">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" id="submitBtn" disabled>
                                Confirmar Reserva
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos de horarios por cancha
        const horariosData = {!! json_encode($horarios->groupBy('cancha_id')->map(function($items) {
            return $items->map(function($item) {
                return [
                    'id' => $item->id,
                    'dia_semana' => $item->dia_semana,
                    'hora_inicio' => $item->hora_inicio,
                    'hora_fin' => $item->hora_fin,
                    'precio' => $item->precio,
                ];
            })->values();
        })) !!};

        // Reservas ya confirmadas
        const reservasConfirmadas = {!! json_encode($reservasConfirmadas->keys()) !!};

        const diasSemana = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];

        // Función para obtener el día de forma correcta
        function obtenerDiaSemana(fecha) {
            const date = new Date(fecha + 'T00:00:00');
            return diasSemana[date.getDay()];
        }

        const canchaSelect = document.getElementById('cancha_id');
        const fechaInput = document.getElementById('fecha');
        const horarioSelect = document.getElementById('horario_id');
        const jugadoresInput = document.getElementById('cantidad_jugadores');
        const submitBtn = document.getElementById('submitBtn');
        const fechaContainer = document.getElementById('fechaContainer');
        const horarioContainer = document.getElementById('horarioContainer');
        const jugadoresContainer = document.getElementById('jugadoresContainer');
        const precioInfo = document.getElementById('precioInfo');

        // Cuando selecciona cancha
        canchaSelect.addEventListener('change', function() {
            if (this.value) {
                fechaContainer.style.display = 'block';
                horarioContainer.style.display = 'none';
                jugadoresContainer.style.display = 'none';
                horarioSelect.innerHTML = '<option value="">-- Elige un horario --</option>';
                fechaInput.value = '';
                jugadoresInput.value = '';
                submitBtn.disabled = true;
            } else {
                fechaContainer.style.display = 'none';
                horarioContainer.style.display = 'none';
                jugadoresContainer.style.display = 'none';
                submitBtn.disabled = true;
            }
        });

        // Cuando selecciona fecha
        fechaInput.addEventListener('change', function() {
            if (this.value && canchaSelect.value) {
                horarioContainer.style.display = 'block';
                jugadoresContainer.style.display = 'none';
                cargarHorarios();
            }
        });

        // Cargar horarios de la cancha seleccionada (filtrando por día)
        function cargarHorarios() {
            const canchaId = canchaSelect.value;
            const fecha = fechaInput.value;
            const fecha_obj = new Date(fecha);
            const diaSemana = obtenerDiaSemana(fecha);
            
            const horarios = horariosData[canchaId] || [];
            
            horarioSelect.innerHTML = '<option value="">-- Elige un horario --</option>';
            
            if (horarios.length === 0) {
                horarioSelect.innerHTML += '<option disabled>No hay horarios disponibles</option>';
                return;
            }

            // Filtrar horarios que coincidan con el día de la semana
            const horariosDelDia = horarios.filter(h => h.dia_semana === diaSemana);

            if (horariosDelDia.length === 0) {
                horarioSelect.innerHTML += '<option disabled>No hay horarios para ' + diaSemana + '</option>';
                return;
            }

            horariosDelDia.forEach(horario => {
                // Verificar si el horario está reservado
                const key = `${canchaId}-${fecha}-${horario.id}`;
                const estaReservado = reservasConfirmadas.includes(key);
                
                const option = document.createElement('option');
                option.value = horario.id;
                option.dataset.precio = horario.precio;
                
                if (estaReservado) {
                    option.textContent = `${horario.hora_inicio} - ${horario.hora_fin} (RESERVADO)`;
                    option.disabled = true;
                    option.style.color = '#999';
                } else {
                    option.textContent = `${horario.hora_inicio} - ${horario.hora_fin}`;
                }
                
                horarioSelect.appendChild(option);
            });
        }

        // Cuando selecciona horario
        horarioSelect.addEventListener('change', function() {
            if (this.value) {
                jugadoresContainer.style.display = 'block';
                const selectedOption = this.options[this.selectedIndex];
                const precio = selectedOption.dataset.precio;
                precioInfo.innerHTML = `<strong>Precio: $${new Intl.NumberFormat('es-CO').format(precio)}</strong>`;
                submitBtn.disabled = false;
            } else {
                jugadoresContainer.style.display = 'none';
                precioInfo.innerHTML = '';
                submitBtn.disabled = true;
            }
        });

        // Validación final
        document.getElementById('reservaForm').addEventListener('submit', function(e) {
            if (!canchaSelect.value || !fechaInput.value || !horarioSelect.value || !jugadoresInput.value) {
                e.preventDefault();
                alert('Por favor completa todos los pasos');
            }
        });
    </script>
@endsection