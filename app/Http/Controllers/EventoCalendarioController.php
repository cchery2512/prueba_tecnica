<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventoCalendarioRequest;
use App\Http\Requests\UpdateEventoCalendarioRequest;
use App\Models\EventoCalendario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventoCalendarioController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return EventoCalendario::
        when(request('fecha_hora_inicio') && request('fecha_hora_fin'),function ($q){
            $q->where(function ($query) {
                $query->where('fecha_hora_inicio', '>=', Carbon::parse(request('fecha_hora_inicio'))->format('Y-m-d H:i:s'))
                    ->where('fecha_hora_fin', '<=', Carbon::parse(request('fecha_hora_fin'))->format('Y-m-d H:i:s'));
            });
        })
        ->with(['tipo_evento', 'u_crea', 'u_modifica'])->orderBy('id')->get();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoCalendarioRequest $request)
    {
        $data = $request->validated();
        $data['usuario_crea'] = auth()->user()->id;

        $eventoCalendario = EventoCalendario::create($data);

        $eventoCalendario->load(['tipo_evento', 'u_crea'])->find($eventoCalendario->id);

        return response()->json($eventoCalendario);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventoCalendario $eventoCalendario)
    {
        return $eventoCalendario->load(['tipo_evento', 'u_crea', 'u_modifica']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoCalendarioRequest $request, EventoCalendario $eventoCalendario)
    {
        $data = $request->validated();
        $data['usuario_modifica'] = auth()->user()->id;

        $eventoCalendario->update($data);

        $eventoCalendario->load(['tipo_evento', 'u_crea', 'u_modifica'])->find($eventoCalendario->id);

        return response()->json($eventoCalendario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventoCalendario $eventoCalendario)
    {
        $eventoCalendario->delete();
        return EventoCalendario::with(['tipo_evento', 'u_crea', 'u_modifica'])->orderBy('id')->get();
    }
}
