<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SubastaController;

Route::get('/', function () {
    $nodo = gethostname();

    try {
        // Enviamos una consulta al nodo db a través de la red de Docker
        $version = DB::scalar('select version()');
        $estadoDB = 'Funcionando: ' . $version;
    } catch (Throwable $e) {
        // Si db no respondió, capturamos el fallo e informamos el error
        $estadoDB = 'Caído: ' . $e->getMessage();
    }

    return "Servidor web (app): Funcionando en el nodo $nodo <br><br>" .
        "Base de datos (db): $estadoDB";
});

// Ruta para la Prueba 1: Sala de mensajes en tiempo real
Route::get('/sala', function () {
    return view('sala');
});

// Rutas para la Prueba 2: Sistema de Subastas
Route::get('/subastas', [SubastaController::class, 'index']);
Route::post('/subastas/{subasta}/pujar', [SubastaController::class, 'pujar']);