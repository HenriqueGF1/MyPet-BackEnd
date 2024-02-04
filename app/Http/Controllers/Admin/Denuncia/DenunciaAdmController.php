<?php

namespace App\Http\Controllers\Admin\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Resources\Denuncia\DenunciaAnimalResource;
use App\Http\Services\Admin\Denuncia\DenunciaAdmService;

class DenunciaAdmController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new DenunciaAdmService();
    }

    public function index()
    {
        return DenunciaAnimalResource::collection(
            $this->service->index()
        );
    }

    public function verificadas()
    {
        return DenunciaAnimalResource::collection(
            $this->service->verificadas()
        );
    }

    public function retiradas()
    {
        return DenunciaAnimalResource::collection(
            $this->service->retiradas()
        );
    }

    public function show(string $id)
    {
        return new DenunciaAnimalResource(
            $this->service->show($id)
        );
    }
}
