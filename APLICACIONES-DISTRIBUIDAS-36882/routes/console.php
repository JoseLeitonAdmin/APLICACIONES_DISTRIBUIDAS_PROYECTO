<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sala:enviar {texto}', function (string $texto) {
    App\Events\MensajeSala::dispatch($texto);
    $this->info('Mensaje enviado al canal sala');
});