<?php


namespace App\Services;


use App\Events\PujaRealizada;
use App\Models\Subasta;
use RuntimeException;


class PujaService
{
    public function pujar(Subasta $subasta, string $nombre, int $monto): void
    {
        if ($subasta->cerrada) {
            throw new RuntimeException('La subasta ya está cerrada');
        }


        if ($monto <= $subasta->precio_actual) {
            throw new RuntimeException("La puja debe superar {$subasta->precio_actual}");
        }


        $subasta->precio_actual = $monto;
        $subasta->lider = $nombre;
        $subasta->save();


        PujaRealizada::dispatch($subasta->id, $monto, $nombre);
    }
}
