<?php

namespace App\Services\Admin\Animal;

use Carbon\Carbon;
use App\Models\PorteAnimal;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Http\Requests\Animal\StoreUpdatePorteAnimalRequest;

class PorteAnimalService
{
    protected $model;
    protected $formRequest;

    public function __construct()
    {
        $this->model = new PorteAnimal();
        $this->formRequest = new StoreUpdatePorteAnimalRequest();
    }
    public function index()
    {
        try {
            return $this->model->whereNull(
                ['dt_inativacao', 'dt_exclusao']
            )->paginate();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function indexADM()
    {
        try {
            return $this->model->paginate();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function show(string $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store($request)
    {

        $porteAnimalDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {
            $porte = $this->model->create($porteAnimalDados->validated());
            DB::commit();
            return $porte;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function update($request, $id)
    {
        $porteAnimalDados = app($this->formRequest::class,  $request->toArray());

        DB::beginTransaction();

        try {
            $porteAnimal = $this->model->findOrFail($id);

            $porteAnimal->descricao = $porteAnimalDados->validated()['descricao'];

            $porteAnimal->save();
            DB::commit();
            return $porteAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $porte = $this->model->findOrFail($id)->delete();
            DB::commit();
            return $porte;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function desativar($id)
    {
        DB::beginTransaction();

        try {
            $porteAnimal = $this->model->findOrFail($id);

            $porteAnimal->dt_inativacao = Carbon::now();

            $porteAnimal->save();
            DB::commit();
            return $porteAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function ativar($id)
    {
        DB::beginTransaction();

        try {
            $porteAnimal = $this->model->findOrFail($id);

            $porteAnimal->dt_inativacao = null;

            $porteAnimal->save();
            DB::commit();
            return $porteAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
