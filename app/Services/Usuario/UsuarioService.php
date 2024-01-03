<?php

namespace App\Services\Usuario;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ErroGeralException;
use App\Http\Resources\Usuario\UsuarioResource;
use App\Http\Requests\Usuario\LoginUsuarioRequest;
use App\Http\Requests\Usuario\StoreUpdateUsuarioRequest;
use App\Services\Usuario\Contato\ContatoService;
use App\Services\Usuario\Endereco\EnderecoService;

use function PHPUnit\Framework\isNull;

class UsuarioService
{
    protected $model;
    protected $formRequest;
    protected $contatoRequest;

    public function __construct()
    {
        $this->model = new Usuario();
        $this->formRequest = new StoreUpdateUsuarioRequest();
    }

    public function checkToken()
    {
        return response()->json([
            'code' => auth()->check() ? 200 : 498,
            'valid' => auth()->check()
        ]);
    }

    public function checkPerfil()
    {
        try {
            if ($this->getIdUsuarioLoged() != null) {
                $perfil = $this->model->findOrFail($this->getIdUsuarioLoged())->perfil_usuario()->orderBy('id_perfil', 'asc')->first();
                return response()->json([
                    'code' =>  200,
                    'perfil' => $perfil
                ]);
            } else {
                return response()->json([
                    'code' =>  401,
                    'perfil' => null
                ]);
            }
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function login(LoginUsuarioRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'data' => 'Usuario ou Senha Incorretos'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        try {

            Auth::logout();

            return response()->json([
                'code' => 200,
                'message' => 'Sucesso logout'
            ]);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    /**
     * Retorna o ID do Usuario Logado
     */
    public static function getIdUsuarioLoged()
    {
        try {
            return Auth::id();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function store($request)
    {

        $usuarioRequest = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $validados = $usuarioRequest->safe()->merge([
                "password" => bcrypt($usuarioRequest->validated()['password'])
            ]);

            $usuario = $this->model->create($validados->toArray());

            $usuario->perfil_usuario()->create([
                'id_perfil' => 2,
                'id_usuario' => $usuario->id_usuario
            ]);

            $contato = $usuario->contatos()->create($validados->toArray());

            $contatoService = new ContatoService();

            $contatoService->checarContatoPrincipal($usuario->id_usuario, $contato->id_contato);

            $validados = $usuarioRequest->safe()->merge([
                'numero' => str_replace("-", "", $usuarioRequest->validated()['numero_endereco'])
            ]);

            $endereco = $usuario->enderecos()->create($validados->toArray());

            $endereçoService = new EnderecoService();

            $endereçoService->checarContatoPrincipal($usuario->id_usuario, $endereco->id_endereco);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }

        $token = Auth::login($usuario);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
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
    }

    public function update(object $request, string $id)
    {

        $usuarioRequest = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $usuario = $this->model->where('id_usuario', '=', $id)->firstOrFail();

            $usuario->nome = $usuarioRequest->validated()['nome'];

            $usuario->save();
            DB::commit();
            return $usuario;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function destroy(string $id)
    {

        DB::beginTransaction();

        try {
            $this->model->destroy($id);
            // $this->logout();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function denunciado($idUsuario)
    {

        DB::beginTransaction();

        try {
            $usuario = $this->model->findOrFail($idUsuario);

            $usuario->qtd_denuncia = $usuario->qtd_denuncia + 1;

            $usuario->save();
            DB::commit();
            return $this->model->findOrFail($idUsuario);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function retirarDenuncia($idUsuario)
    {

        DB::beginTransaction();

        try {

            $usuario = $this->model->findOrFail($idUsuario);

            $usuario->qtd_denuncia = $usuario->qtd_denuncia - 1;

            $usuario->save();
            DB::commit();
            return $this->model->findOrFail($idUsuario);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
