<?php

use App\Services\PujaService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sala:enviar {texto}', function (string $texto) {
    App\Events\MensajeSala::dispatch($texto);
    $this->info('Mensaje enviado al canal sala');
});

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

Artisan::command('pujar {subasta} {nombre} {monto}', function (PujaService $servicio, int $subasta, string $nombre, int $monto) {
    $servicio->pujar(App\Models\Subasta::findOrFail($subasta), $nombre, $monto);
    $this->info('Puja registrada');
});

Schedule::command('subastas:cerrar')->everyTenSeconds();