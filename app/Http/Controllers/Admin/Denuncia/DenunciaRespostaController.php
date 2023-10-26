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
        try {
            return DenunciaRespostaResource::collection(
                $this->service->index()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function show(string $id)
    {
        try {
            return new DenunciaRespostaResource(
                $this->service->show($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            return new DenunciaRespostaResource(
                $this->service->validarDenuncia($request)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
