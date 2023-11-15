<?php

namespace App\Http\Controllers\Denuncia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Denuncia\DenunciaAnimalService;
use App\Http\Resources\Denuncia\DenunciaAnimalResource;
use App\Http\Requests\Denuncia\StoreUpdateDenunciaAnimalRequest;

class DenunciaAnimalController extends Controller
{
    protected $service;
    protected $formRequest;
    public function __construct()
    {
        $this->service = new DenunciaAnimalService();
        $this->formRequest = new StoreUpdateDenunciaAnimalRequest();
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
    public function store(Request $request)
    {
        try {
            return new DenunciaAnimalResource(
                $this->service->store($request)
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
    public function update(Request $request, string $id)
    {
        try {
            return new DenunciaAnimalResource(
                $this->service->update($request, $id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function retirarDenuncia(string $id)
    {
        // try {
            return new DenunciaAnimalResource(
                $this->service->retirarDenuncia($id)
            );
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
}
