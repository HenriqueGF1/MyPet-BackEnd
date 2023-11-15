<?php

namespace App\Services\Denuncia;

use Carbon\Carbon;
use App\Models\DenunciaAnimal;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Services\Animal\AnimalService;
use App\Services\Usuario\UsuarioService;
use App\Http\Requests\Denuncia\StoreUpdateDenunciaAnimalRequest;

class DenunciaAnimalService
{
    protected $model;
    protected $formRequest;

    public function __construct()
    {
        $this->model = new DenunciaAnimal();
        $this->formRequest = new StoreUpdateDenunciaAnimalRequest();
    }

    public function index()
    {
        try {
            // return $this->model->whereNull(
            //     ['dt_inativacao', 'dt_exclusao']
            // )->paginate();
            return $this->model->where(
                'id_usuario_denunciante',
                '=',
                UsuarioService::getIdUsuarioLoged()
            )->paginate();
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

        $denunciaDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $denuncia = $denunciaDados->safe()->merge([
                "id_usuario_denunciante" => UsuarioService::getIdUsuarioLoged()
            ]);

            $animal = new AnimalService();
            $usuario = new UsuarioService();

            $animal->denunciado($denuncia->id_animal);
            $usuario->denunciado($denuncia->id_usuario);

            $denunciaAnimal = $this->model->create($denuncia->toArray());

            DB::commit();
            return $denunciaAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function retirarDenuncia(string $id)
    {
        DB::beginTransaction();

        try {
            $denuncia = $this->model->findOrFail($id);

            $denuncia->dt_exclusao = Carbon::now();

            $animal = new AnimalService();
            $usuario = new UsuarioService();

            $animal->retirarDenuncia($denuncia->id_animal);
            $usuario->retirarDenuncia($denuncia->id_usuario);

            $denuncia->save();
            DB::commit();
            return $denuncia;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function update($request, string $id)
    {

        $denunciaDados = app($this->formRequest::class, $request->toArray());
        DB::beginTransaction();

        try {

            $denuncia = $this->model->findOrFail($id);

            $denuncia->descricao = $denunciaDados->validated()['descricao'];
            $denuncia->id_tipo = $denunciaDados->validated()['id_tipo'];

            $denuncia->save();
            DB::commit();
            return $denuncia;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    /**
     * Quando e aceito a denuncia contra o animal , o animal e sua denuncia sao desativados
     */
    public function desativarDenuncia($id)
    {

        DB::beginTransaction();

        try {
            $animal = $this->model->findOrFail($id);
            $animal->dt_inativacao = Carbon::now();
            $animal->save();
            DB::commit();
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
