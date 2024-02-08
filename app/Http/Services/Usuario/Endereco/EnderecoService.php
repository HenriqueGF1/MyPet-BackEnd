<?php

namespace App\Http\Services\Usuario\Endereco;

use App\Models\Endereco;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Http\Services\Usuario\UsuarioService;
use App\Http\Requests\Usuario\Endereco\StoreUpdateEnderecoRequest;

class EnderecoService
{

    protected $model;
    protected $formRequest;

    public function __construct()
    {
        $this->model = new Endereco();
        $this->formRequest = new StoreUpdateEnderecoRequest();
    }

    public function index()
    {

        try {
            return $this->model->where('id_usuario', '=', UsuarioService::getIdUsuarioLoged())->orderBy('principal', 'desc')->get();
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

        $enderecoDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $validados = $enderecoDados->safe()->merge([
                "id_usuario" => UsuarioService::getIdUsuarioLoged(),
                "numero" => $enderecoDados->numero_endereco,
            ]);

            $endereco = $this->model->create($validados->toArray());

            $this->checarContatoPrincipal($validados->id_usuario, $endereco->id_endereco);

            DB::commit();

            return $endereco;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function checarContatoPrincipal(string $idUsuario, string $idEndereco)
    {

        try {

            $endereco = $this->model->where('id_usuario', '=', $idUsuario)->get();
            if (count($endereco) == 1) {
                $this->definirPrincipal($idEndereco);
            }
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function definirPrincipal(string $idEndereco): object
    {

        DB::beginTransaction();

        try {

            $this->model->where('id_usuario', UsuarioService::getIdUsuarioLoged())->update([
                'principal' => 0
            ]);

            $endereco = $this->model->where('id_endereco', '=', $idEndereco)->firstOrFail();

            $endereco->principal = 1;

            $endereco->save();

            DB::commit();

            return $endereco;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function update($request, $id): object
    {

        $enderecoDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $endereco = $this->model->where('id_endereco', '=', $id)->firstOrFail();

            $endereco->numero = $enderecoDados->validated()['numero_endereco'];
            $endereco->cep = $enderecoDados->validated()['cep'];
            $endereco->bairro = $enderecoDados->validated()['bairro'];
            $endereco->complemento = $enderecoDados->validated()['complemento'];

            $endereco->save();

            DB::commit();

            return $endereco;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();

        try {

            $endereco = $this->model->findOrFail($id);

            if ($endereco->principal == 1) {
                return response()->json([
                    "data" => [
                        "message" => "Não e possível excluir o endereço principal."
                    ]
                ], 200);
            }

            $enderecoDeletar = $endereco->delete();

            DB::commit();

            return $enderecoDeletar;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
