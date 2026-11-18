<?php

namespace App\Http\Controllers;

use App\Models\Subasta;
use App\Services\PujaService;
use Illuminate\Http\Request;
use RuntimeException;

class SubastaController extends Controller
{
    public function index()
    {
        return view('subastas.index', ['subastas' => Subasta::orderBy('id')->get()]);
    }

    public function pujar(Request $request, Subasta $subasta, PujaService $servicio)
    {
        $nombre = trim($request->input('nombre'));
        $monto = (int) $request->input('monto');

        try {
            $servicio->pujar($subasta, $nombre, $monto);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }
}
