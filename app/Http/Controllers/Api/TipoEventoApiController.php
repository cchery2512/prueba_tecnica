<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoEventoRequest;
use App\Http\Requests\UpdateTipoEventoRequest;
use App\Models\TipoEvento;


class TipoEventoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TipoEvento::orderBy('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoEventoRequest $request)
    {
        $data = $request->validated();

        $tipoEvento = TipoEvento::create($data);

        $tipoEvento->find($tipoEvento->id);

        return response()->json($tipoEvento);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoEvento $tipoEvento)
    {
        return $tipoEvento;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoEventoRequest $request, TipoEvento $tipoEvento)
    {
        $data = $request->validated();

        $tipoEvento->update($data);

        return response()->json($tipoEvento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoEvento $tipoEvento)
    {
        $tipoEvento->delete();
        return TipoEvento::orderBy('id')->get();
    }
}
