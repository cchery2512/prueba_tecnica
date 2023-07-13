<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoEventoRequest;
use App\Http\Requests\UpdateTipoEventoRequest;
use App\Models\TipoEvento;
use Illuminate\Http\Request;

class TipoEventoController extends Controller
{
    public function index()
    {
        $tipos = TipoEvento::all();

        return view('tipoEvento.list', compact('tipos'));
    }

    public function create()
    {
    }

    public function store(StoreTipoEventoRequest $request)
    {
        $data = $request->validated();

        $tipoEvento = TipoEvento::create($data);

        $tipos = TipoEvento::all();

        return view('tipoEvento.list', compact('tipos'));
    }

    public function show(TipoEvento $tipoEvento)
    {
    }

    public function edit(TipoEvento $tipoEvento)
    {
    }

    public function update(UpdateTipoEventoRequest $request, TipoEvento $tipoevento)
    {
        $data = $request->validated();

        $tipoevento->update($data);

        return redirect()->back();
    }

    public function destroy(TipoEvento $tipoevento)
    {
        $tipoevento->delete();
        return redirect()->back();
    }
}
