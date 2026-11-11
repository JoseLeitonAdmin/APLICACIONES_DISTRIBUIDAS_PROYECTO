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
        $monto = (int) $request->input('monto');

        if ($monto <= $subasta->precio_actual) {
            return back()->with('error', "La puja debe superar {$subasta->precio_actual}");
        }

        $subasta->precio_actual = $monto;
        $subasta->save();

        PujaRealizada::dispatch($subasta->id, $monto);

        return back();
    }
}
