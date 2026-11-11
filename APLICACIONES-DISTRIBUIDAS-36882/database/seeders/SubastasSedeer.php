<?php

namespace Database\Seeders;

use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubastasSedeer extends Seeder
{

    public function run(): void
    {
        $articos = [
            ['Carro mazda','Tiene un rayon',5000],
            ['Iphone 17','Es nuevo',100]
        ];

        foreach($articos as [$titulo,$descripcion,$precio]){
            Subasta::create([
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'precio_inicial' => $precio,
                'precio_actual' => $precio,
                'termina_en' => now() -> addDays(2),
            ]);
        }
    }
}
