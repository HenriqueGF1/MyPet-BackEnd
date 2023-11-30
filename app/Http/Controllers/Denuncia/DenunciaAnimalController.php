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
        return DenunciaAnimalResource::collection(
            $this->service->index()
        );
    }
    public function store(Request $request)
    {
        return new DenunciaAnimalResource(
            $this->service->store($request)
        );
    }
    public function show(string $id)
    {
        return new DenunciaAnimalResource(
            $this->service->show($id)
        );
    }
    public function update(Request $request, string $id)
    {
        return new DenunciaAnimalResource(
            $this->service->update($request, $id)
        );
    }
    public function retirarDenuncia(string $id)
    {
        return new DenunciaAnimalResource(
            $this->service->retirarDenuncia($id)
        );
    }
}
