<?php

namespace App\Http\Controllers\Admin\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Animal\PorteAnimalResource;
use App\Http\Services\Admin\Animal\PorteAnimalService;


class PorteAnimalController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new PorteAnimalService();
    }

    public function index()
    {
        return PorteAnimalResource::collection(
            $this->service->index()
        );
    }

    public function indexADM()
    {
        return PorteAnimalResource::collection(
            $this->service->indexADM()
        );
    }

    public function store(Request $request)
    {
        return new PorteAnimalResource(
            $this->service->store($request)
        );
    }

    public function show(string $id)
    {
        return new PorteAnimalResource(
            $this->service->show($id)
        );
    }

    public function update(Request $request, string $id)
    {
        return new PorteAnimalResource(
            $this->service->update($request, $id)
        );
    }

    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }

    public function desativar(string $id)
    {
        return new PorteAnimalResource(
            $this->service->desativar($id)
        );
    }

    public function ativar(string $id)
    {
        return new PorteAnimalResource(
            $this->service->ativar($id)
        );
    }
}
