<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrarRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserApiController extends Controller
{
    public function index()
    {
        User::orderBy('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrarRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $user->find($user->id);

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        return $usuario;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $usuario)
    {
        $data = $request->validated();

        $usuario->update($data);

        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return User::orderBy('id')->get();
    }
}
