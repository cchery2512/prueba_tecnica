<?php

namespace App\Http\Controllers;

use App\Models\EventoCalendario;
use App\Models\TipoEvento;

class HomeController extends Controller
{
    public function index()
    {
        $tipos = TipoEvento::all();
        $eventos = EventoCalendario::all();
        return view('home', compact('tipos', 'eventos'));
    }
}
