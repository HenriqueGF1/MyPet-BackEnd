<?php

namespace App\Http\Controllers\Admin\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Admin\Animal\CategoriaAnimalService;
use App\Http\Resources\Animal\CategoriaAnimalResource;

class CategoriaAnimalController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new CategoriaAnimalService();
    }
    public function index()
    {
        return CategoriaAnimalResource::collection(
            $this->service->index()
        );
    }
    public function indexADM()
    {
        return CategoriaAnimalResource::collection(
            $this->service->indexADM()
        );
    }
    public function store(Request $request)
    {
        return new CategoriaAnimalResource(
            $this->service->store($request)
        );
    }
    public function show(string $id)
    {
        return new CategoriaAnimalResource(
            $this->service->show($id)
        );
    }
    public function update(Request $request, string $id)
    {
        return new CategoriaAnimalResource(
            $this->service->update($request, $id)
        );
    }
    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }
    public function desativar(string $id)
    {
        return new CategoriaAnimalResource(
            $this->service->desativar($id)
        );
    }
    public function ativar(string $id)
    {
        return new CategoriaAnimalResource(
            $this->service->ativar($id)
        );
    }
}
