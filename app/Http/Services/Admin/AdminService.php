<?php

namespace App\Http\Services\Admin;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ErroGeralException;
use App\Http\Resources\Usuario\UsuarioResource;
use App\Http\Requests\Usuario\LoginUsuarioRequest;
use App\Models\Animal;

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
                return response()->json([
                    'code' => 404,
                    'errors' => 'Senha ou E-mail errados',
                ], 401);
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
                    'errors' => 'Não autorizado',
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

    public function dashBoard()
    {

        try {

            // Usuario
            $usuario = Usuario::all();
            // Animal
            $animal = Animal::all();
            $animaisQtdDenuncias = Animal::sum('qtd_denuncia');
            $animaisAdotados = Animal::where('adotado', '=', '1')->get();
            $animaisNaoAdotados = Animal::where('adotado', '=', '0')->get();
            $animaisMasculinos = Animal::where('sexo', '=', 'M')->get();
            $animaisFemininos = Animal::where('sexo', '=', 'F')->get();

            return [
                'data' => [
                    'usuario' => $usuario->count(),
                    'animal' => $animal->count(),
                    'animaisQtdDenuncias' => intval($animaisQtdDenuncias),
                    'animaisAdotados' => $animaisAdotados->count(),
                    'animaisNaoAdotados' => $animaisNaoAdotados->count(),
                    'animaisMasculinos' => $animaisMasculinos->count(),
                    'animaisFemininos' => $animaisFemininos->count()
                ]
            ];
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
