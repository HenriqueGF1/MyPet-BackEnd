<?php

namespace App\Http\Controllers\Admin\Denuncia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Denuncia\DenunciaRespostaResource;
use App\Http\Services\Admin\Denuncia\DenunciaRespostaService;

class DenunciaRespostaController extends Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new DenunciaRespostaService;
    }

    public function index()
    {
        return DenunciaRespostaResource::collection(
            $this->service->index()
        );
    }

    public function respostaDenunciaUsuario(string $idAnimal)
    {
        return new DenunciaRespostaResource(
            $this->service->respostaDenunciaUsuario($idAnimal)
        );
    }

    public function show(string $id)
    {
        return new DenunciaRespostaResource(
            $this->service->show($id)
        );
    }

    public function store(Request $request)
    {
        return new DenunciaRespostaResource(
            $this->service->validarDenuncia($request)
        );
    }
}
