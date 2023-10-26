<?php

namespace App\Services\Admin\Animal;

use Carbon\Carbon;
use App\Models\CategoriaAnimal;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Http\Requests\Animal\StoreUpdateCategoriaAnimalRequest;

class CategoriaAnimalService
{
    protected $model;
    protected $formRequest;

    public function __construct()
    {
        $this->model = new CategoriaAnimal();
        $this->formRequest = new StoreUpdateCategoriaAnimalRequest();
    }
    public function index()
    {
        return $this->model->whereNull(
            ['dt_inativacao', 'dt_exclusao']
        )->paginate();
    }
    public function indexADM()
    {
        return $this->model->paginate();
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

        $categoriaAnimalDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {
            $categoria = $this->model->create((array) $categoriaAnimalDados->validated());
            DB::commit();
            return $categoria;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function update($request, string $id)
    {

        $categoriaAnimalDados = app($this->formRequest::class,  $request->toArray());

        DB::beginTransaction();

        try {
            $categoriaAnimal = $this->model->findOrFail($id);

            $categoriaAnimal->descricao = $categoriaAnimalDados->validated()['descricao'];

            $categoriaAnimal->save();
            DB::commit();
            return $categoriaAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function destroy(string $id)
    {

        DB::beginTransaction();
        
        try {
            $categoria = $this->model->findOrFail($id)->delete();
            DB::commit();
            return $categoria;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function desativar(string $id)
    {

        DB::beginTransaction();

        try {
            $categoriaAnimal = $this->model->findOrFail($id);

            $categoriaAnimal->dt_inativacao = Carbon::now();

            $categoriaAnimal->save();
            DB::commit();
            return $categoriaAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function ativar(string $id)
    {

        DB::beginTransaction();

        try {
            $categoriaAnimal = $this->model->findOrFail($id);

            $categoriaAnimal->dt_inativacao = null;

            $categoriaAnimal->save();
            DB::commit();
            return $categoriaAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
