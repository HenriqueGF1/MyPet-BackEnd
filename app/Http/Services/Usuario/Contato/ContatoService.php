<?php

namespace App\Http\Services\Usuario\Contato;

use App\Models\Contato;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Http\Services\Usuario\UsuarioService;
use App\Http\Requests\Usuario\Contato\StoreUpdateContatoRequest;

class ContatoService
{

    protected $model;
    protected $formRequest;

    public function __construct()
    {
        $this->model = new Contato();
        $this->formRequest = new StoreUpdateContatoRequest();
    }

    public function index()
    {

        try {
            return $this->model->where('id_usuario', '=', UsuarioService::getIdUsuarioLoged())->orderBy('principal', 'desc')->get();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function show($id): object
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function store($request)
    {

        $contatoDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $validados = $contatoDados->safe()->merge([
                "id_usuario" => UsuarioService::getIdUsuarioLoged(),
                'numero' => str_replace("-", "", $contatoDados->numero)
            ]);

            $contato = $this->model->create($validados->toArray());

            $this->checarContatoPrincipal($validados->id_usuario, $contato->id_contato);

            DB::commit();

            return $contato;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function checarContatoPrincipal(string $idUsuario, string $idContato)
    {

        try {
            $contato = $this->model->where('id_usuario', '=', $idUsuario)->get();
            if (count($contato) == 1) {
                $this->definirPrincipal($idContato);
            }
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function definirPrincipal(string $idContato): object
    {

        DB::beginTransaction();

        try {

            $this->model->where('id_usuario', UsuarioService::getIdUsuarioLoged())->update([
                'principal' => 0
            ]);

            $contato = $this->model->where('id_contato', '=', $idContato)->firstOrFail();

            $contato->principal = 1;

            $contato->save();

            DB::commit();

            return $contato;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function update($request, $id): object
    {

        $contatoDados = app($this->formRequest::class, $request->toArray());

        $contatoValidado = $contatoDados->validated();

        DB::beginTransaction();

        try {

            $contato = $this->model->where('id_contato', '=', $id)->firstOrFail();

            $contato->dd = $contatoValidado['dd'];
            $contato->numero = str_replace("-", "", $contatoDados->numero);

            $contato->save();

            DB::commit();

            return $contato;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function destroy(string $id)
    {

        DB::beginTransaction();

        try {

            $contato = $this->model->findOrFail($id);

            if ($contato->principal == 1) {
                return response()->json([
                    "data" => [
                        "message" => "Não e possível excluir o contato principal."
                    ]
                ], 200);
            }

            $contatoDeletar = $contato->delete();

            DB::commit();

            return $contatoDeletar;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
