<?php

namespace App\Http\Controllers\Admin\Denuncia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Admin\Denuncia\DenunciaRespostaService;
use App\Http\Resources\Denuncia\DenunciaRespostaResource;

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
