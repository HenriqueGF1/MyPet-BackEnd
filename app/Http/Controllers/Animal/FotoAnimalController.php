<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Animal\FotoAnimalService;
use App\Http\Resources\Animal\FotoAnimalResource;

class FotoAnimalController extends Controller
{

    protected $service;
    public function __construct()
    {
        $this->service = new FotoAnimalService();
    }

    public function index(string $idAnimal)
    {
        try {
            return FotoAnimalResource::collection(
                $this->service->index($idAnimal)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            return FotoAnimalResource::collection(
                $this->service->store($request)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function show(string $idAnimal, string $idFoto)
    {
        try {
            return new FotoAnimalResource(
                $this->service->show($idAnimal, $idFoto)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function update(Request $request, string $idAnimal)
    {
        try {
            return FotoAnimalResource::collection(
                $this->service->update($request, $idAnimal)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function destroy(string $idFotoAnimal)
    {
        try {
            return $this->service->destroy($idFotoAnimal);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
