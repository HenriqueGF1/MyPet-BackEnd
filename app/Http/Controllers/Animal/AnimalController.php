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
        try {
            return AnimalResource::collection(
                $this->service->index()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    // Animais do usuário
    public function animaisUsuario(): object
    {
        try {
            return AnimalResource::collection(
                $this->service->animaisUsuario()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    // Mostrar animais inativos
    public function inativos(): object
    {
        try {
            return AnimalResource::collection(
                $this->service->inativos()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store(Request $request)
    {
        // try {
        // return new AnimalResource(
        return $this->service->store(
            $request
        );
        // );
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
    public function show(string $id): object
    {
        try {
            return new AnimalResource($this->service->show($id));
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function update(Request $request, string $id)
    {
        // try {
        return new AnimalResource(
            $this->service->update(
                $request,
                $id
            )
        );
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
    public function destroy(string $id)
    {
        try {
            return $this->service->destroy(
                $id
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    // Desativar animal
    public function desativarAnimal(string $id)
    {
        try {
            return new AnimalResource(
                $this->service->desativarAnimal(
                    $id
                )
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    // Ativar animal
    public function ativarAnimal(string $id)
    {
        try {
            return new AnimalResource(
                $this->service->ativarAnimal(
                    $id
                )
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    //
    public function adotado(string $id, Request $request)
    {
        try {
            return new AnimalResource(
                $this->service->adotado(
                    $id,
                    $request
                )
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
