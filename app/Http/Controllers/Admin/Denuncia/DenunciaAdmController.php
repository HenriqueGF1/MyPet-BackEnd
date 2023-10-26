<?php

namespace App\Http\Controllers\Admin\Denuncia;

use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Admin\Denuncia\DenunciaAdmService;
use App\Http\Resources\Denuncia\DenunciaAnimalResource;

class DenunciaAdmController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new DenunciaAdmService();
    }
    public function index()
    {
        try {
            return DenunciaAnimalResource::collection(
                $this->service->index()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function verificadas()
    {
        try {
            return DenunciaAnimalResource::collection(
                $this->service->verificadas()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function retiradas()
    {
        try {
            return DenunciaAnimalResource::collection(
                $this->service->retiradas()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function show(string $id)
    {
        try {
            return new DenunciaAnimalResource(
                $this->service->show($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
