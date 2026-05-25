<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación (sin middleware)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro de usuario
Route::get('/registro', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/registro', [UsuarioController::class, 'store'])->name('usuarios.store');

// Home (catálogo de canchas - sin proteger)
Route::get('/', [CanchaController::class, 'index'])->name('home');
Route::get('/canchas/{cancha}', [CanchaController::class, 'show'])->name('canchas.show');

// ==========================================
// RUTAS PROTEGIDAS (Requieren sesión iniciada)
// ==========================================
Route::middleware('check.user.session')->group(function () {
    
    // Dashboard de usuario (mis reservas)
    Route::get('/mis-reservas/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
    
    // Crear reserva
    Route::get('/reservar', [ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reservas.store');
    
    // Ver detalle de reserva
    Route::get('/reservas/{reserva}', [ReservaController::class, 'show'])->name('reservas.show');
    
    // Cancelar reserva
    Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');

    // ==========================================
    // RUTAS DE ADMINISTRADOR (Solo usuario ID 1)
    // Combinamos middleware, prefijo de URL y prefijo de nombre en una sola línea elegante
    // ==========================================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Canchas
        Route::get('/canchas', [AdminController::class, 'index'])->name('canchas.index');
        Route::get('/canchas/crear', [AdminController::class, 'create'])->name('canchas.create');
        Route::post('/canchas', [AdminController::class, 'store'])->name('canchas.store');
        Route::get('/canchas/{cancha}/editar', [AdminController::class, 'edit'])->name('canchas.edit');
        Route::put('/canchas/{cancha}', [AdminController::class, 'update'])->name('canchas.update');
        Route::delete('/canchas/{cancha}', [AdminController::class, 'destroy'])->name('canchas.destroy');

        // Horarios
        Route::get('/canchas/{cancha}/horarios', [AdminController::class, 'horarios'])->name('horarios');
        Route::get('/canchas/{cancha}/horarios/crear', [AdminController::class, 'crearHorario'])->name('horarios.create');
        Route::post('/canchas/{cancha}/horarios', [AdminController::class, 'guardarHorario'])->name('horarios.store');
        Route::delete('/horarios/{horario}', [AdminController::class, 'eliminarHorario'])->name('horarios.destroy');   
        
        // Reservas (¡Aquí está la que fallaba!)
        Route::get('/reservas', [AdminController::class, 'reservas'])->name('reservas');

        // Usuarios
        Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
        Route::get('/usuarios/{usuario}/editar', [AdminController::class, 'editarUsuario'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [AdminController::class, 'actualizarUsuario'])->name('usuarios.update');
        Route::delete('/usuarios/{usuario}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.destroy');
    }); // Cierra Admin Group
    
}); // Cierra Check User Session Group