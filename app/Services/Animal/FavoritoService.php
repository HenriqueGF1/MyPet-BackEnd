<?php

namespace App\Services\Animal;

use App\Models\FavoritoAnimal;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Http\Requests\Animal\StoreUpdateFavoritoAnimalRequest;

class FavoritoService
{
    protected $model;
    protected $formRequest;

    public function __construct()
    {
        $this->model = new FavoritoAnimal();
        $this->formRequest = new StoreUpdateFavoritoAnimalRequest();
    }
    public function index()
    {
        try {
            return $this->model->paginate();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store($request)
    {

        $favoritoAnimal = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {
            $favorito = $this->model->create($favoritoAnimal->validated());
            DB::commit();
            return $favorito;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function destroy(string $id)
    {

        DB::beginTransaction();

        try {
            $favorito = $this->model->findOrFail($id)->delete();
            DB::commit();
            return $favorito;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
