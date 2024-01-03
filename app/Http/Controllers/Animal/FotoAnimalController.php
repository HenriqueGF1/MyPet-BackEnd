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
        return FotoAnimalResource::collection(
            $this->service->index($idAnimal)
        );
    }
    public function store(Request $request)
    {
        return FotoAnimalResource::collection(
            $this->service->store($request)
        );
    }
    public function show(string $idAnimal, string $idFoto)
    {
        return new FotoAnimalResource(
            $this->service->show($idAnimal, $idFoto)
        );
    }
    public function update(Request $request, string $idAnimal)
    {
        return FotoAnimalResource::collection(
            $this->service->update($request, $idAnimal)
        );
    }
    public function destroy(Request $request, string $idAnimal)
    {
        return $this->service->destroy($request, $idAnimal);
    }
}
