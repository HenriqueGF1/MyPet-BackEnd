<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Animal\AnimalService;
use App\Http\Resources\Animal\AnimalResource;

class AnimalController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new AnimalService();
    }

    public function index(): object
    {
        return AnimalResource::collection(
            $this->service->index()
        );
    }
    // Animais do usuário
    public function animaisUsuario(): object
    {
        return AnimalResource::collection(
            $this->service->animaisUsuario()
        );
    }
    public function show(string $id): object
    {
        return new AnimalResource($this->service->show($id));
    }
    public function store(Request $request)
    {
        return $this->service->store(
            $request
        );
    }
    public function update(Request $request, string $id)
    {
        return new AnimalResource(
            $this->service->update(
                $request,
                $id
            )
        );
    }
    public function destroy(string $id)
    {
        return $this->service->destroy(
            $id
        );
    }
    // Mostrar animais inativos
    public function inativos(): object
    {
        return AnimalResource::collection(
            $this->service->inativos()
        );
    }
    // Desativar animal
    public function desativarAnimal(string $id)
    {
        return new AnimalResource(
            $this->service->desativarAnimal(
                $id
            )
        );
    }
    // Ativar animal
    public function ativarAnimal(string $id)
    {
        return new AnimalResource(
            $this->service->ativarAnimal(
                $id
            )
        );
    }
    //
    public function adotado(string $id, Request $request)
    {
        return new AnimalResource(
            $this->service->adotado(
                $id,
                $request
            )
        );
    }
}
