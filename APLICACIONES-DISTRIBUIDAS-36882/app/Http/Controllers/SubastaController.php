<?php

namespace App\Http\Controllers;

use App\Models\Subasta;
use App\Events\PujaRealizada;
use Illuminate\Http\Request;

class SubastaController extends Controller
{
    public function index()
    {
        return view('subastas.index', ['subastas' => Subasta::orderBy('id')->get()]);
    }

    public function pujar(Request $request, Subasta $subasta)
{
    $nombre = trim($request->input('nombre'));
    $monto = (int) $request->input('monto');

    if ($subasta->cerrada) {
        return back()->with('error', 'La subasta ya está cerrada');
    }

    if ($monto <= $subasta->precio_actual) {
        return back()->with('error', "La puja debe superar {$subasta->precio_actual}");
    }

    $subasta->precio_actual = $monto;
    $subasta->lider = $nombre;
    $subasta->save();

    PujaRealizada::dispatch($subasta->id, $monto, $nombre);

    return back();
}
}
