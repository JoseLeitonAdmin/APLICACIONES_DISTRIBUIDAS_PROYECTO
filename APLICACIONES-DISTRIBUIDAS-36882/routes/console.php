<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Prueba 1: Comando para enviar mensajes en vivo a /sala
Artisan::command('sala:enviar {texto}', function (string $texto) {
    App\Events\MensajeSala::dispatch($texto);
    $this->info('Mensaje enviado al canal sala');
});

// Prueba 2: Comando para cerrar subastas vencidas
Artisan::command('subastas:cerrar', function () {
    $vencidas = App\Models\Subasta::where('cerrada', false)
        ->where('termina_en', '<=', now())
        ->get();

    foreach ($vencidas as $subasta) {
        $subasta->cerrada = true;
        $subasta->save();
        App\Events\SubastaCerrada::dispatch($subasta->id, $subasta->lider, $subasta->precio_actual);
        $this->info("Subasta {$subasta->id} cerrada. Ganador: " . ($subasta->lider ?? 'nadie'));
    }

    $this->info("Subastas cerradas: {$vencidas->count()}");
});

// Programación de tareas: Ejecuta el cierre automáticamente cada 10 segundos
Schedule::command('subastas:cerrar')->everyTenSeconds();