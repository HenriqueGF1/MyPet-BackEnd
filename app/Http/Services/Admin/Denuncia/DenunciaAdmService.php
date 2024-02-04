<?php

namespace App\Http\Services\Admin\Denuncia;

use App\Models\DenunciaAnimal;
use App\Exceptions\ErroGeralException;

class DenunciaAdmService
{

    protected $model;

    public function __construct()
    {
        $this->model = new DenunciaAnimal();
    }

    public function index()
    {

        try {
            return $this->model
            ->whereNull('dt_inativacao')
            ->whereNull('dt_exclusao')
            ->get();
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

    public function verificadas()
    {

        try {
            return $this->model->whereNotNull('dt_inativacao')->get();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function retiradas()
    {

        try {
            return $this->model->whereNotNull('dt_exclusao')->get();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
