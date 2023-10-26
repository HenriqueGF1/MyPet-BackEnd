<?php

namespace App\Services\Admin\Denuncia;

use Carbon\Carbon;
use App\Models\DenunciaTipo;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Http\Requests\Denuncia\StoreUpdateDenunciaTipoRequest;

class DenunciaTipoService
{
    protected $model;
    protected $formRequest;
    public function __construct()
    {
        $this->model = new DenunciaTipo();
        $this->formRequest = new StoreUpdateDenunciaTipoRequest();
    }
    public function index()
    {
        try {
            return $this->model->all();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store($request)
    {
        $dadosRequest = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {
            $tipoDenuncia = $this->model->create($dadosRequest->validated());
            DB::commit();
            return $tipoDenuncia;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function update($request, $id)
    {

        $dadosRequest = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $tipo = $this->model->findOrFail($id);

            $tipo->descricao = $dadosRequest->validated()['descricao'];

            $tipo->save();
            DB::commit();
            return $tipo;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $tipo = $this->model->findOrFail($id);

            $tipo->dt_exclusao = Carbon::now();

            $tipo->save();
            DB::commit();
            return $tipo;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function inativar($id)
    {
        DB::beginTransaction();

        try {

            $tipo = $this->model->findOrFail($id);

            $tipo->dt_inativacao = Carbon::now();

            $tipo->save();
            DB::commit();
            return $tipo;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function ativar($id)
    {
        DB::beginTransaction();

        try {

            $tipo = $this->model->findOrFail($id);

            $tipo->dt_inativacao = null;

            $tipo->save();
            DB::commit();
            return $tipo;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
