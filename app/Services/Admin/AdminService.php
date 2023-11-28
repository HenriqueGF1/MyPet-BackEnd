<?php

namespace App\Services\Admin;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ErroGeralException;
use App\Http\Resources\Usuario\UsuarioResource;
use App\Http\Requests\Usuario\LoginUsuarioRequest;

class AdminService
{
    protected $model;
    protected $formRequest;
    public function __construct()
    {
        $this->model = new Usuario();
        $this->formRequest = new LoginUsuarioRequest();
    }
    public function login($request)
    {

        $credentials = app($this->formRequest::class, $request->toArray());

        try {

            if (!$token = Auth::attempt($credentials->validated())) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user = Auth::user();

            $usuario = $this->model->findOrFail($user->id_usuario);

            $usuarioPerfil = $usuario->perfil_usuario()->orderBy('id_perfil')->first();

            // ADMIN
            if ($usuarioPerfil['id_perfil'] == 1) {
                return $this->respondWithToken($token);
            } else {
                return response()->json([
                    'code' => 401,
                    'error' => 'Unauthorized',
                ], 401);
            }
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    protected function respondWithToken($token)
    {
        try {

            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'user' => new UsuarioResource($user),
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * 60,
                ],
            ]);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
