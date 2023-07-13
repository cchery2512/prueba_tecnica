<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventoCalendarioRequest;
use App\Http\Requests\UpdateEventoCalendarioRequest;
use App\Models\EventoCalendario;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(StoreEventoCalendarioRequest $request)
    {
        $data = $request->validated();
        $data['usuario_crea'] = auth()->user()->id;

        $eventoCalendario = EventoCalendario::create($data);

        return redirect()->back();
    }

    public function show(EventoCalendario $eventoCalendario)
    {
    }

    public function edit(EventoCalendario $eventoCalendario)
    {
    }

    public function update(UpdateEventoCalendarioRequest $request, EventoCalendario $calendario)
    {
        $data = $request->validated();
        $data['usuario_modifica'] = auth()->user()->id;

        $calendario->update($data);

        $calendario->load(['tipo_evento', 'u_crea', 'u_modifica'])->find($calendario->id);

        return redirect()->back();
    }

    public function destroy(EventoCalendario $eventoCalendario)
    {
    }
}
