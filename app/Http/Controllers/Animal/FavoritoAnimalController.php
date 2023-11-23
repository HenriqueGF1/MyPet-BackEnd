<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Animal\FavoritoService;
use App\Http\Resources\Animal\FavoritoAnimalResource;

class FavoritoAnimalController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new FavoritoService();
    }

    public function index()
    {
        // try {
            return FavoritoAnimalResource::collection(
                $this->service->index()
            );
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
    public function store(Request $request)
    {
        try {
            return new FavoritoAnimalResource(
                $this->service->store($request)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function destroy(string $id)
    {
        try {
            return $this->service->destroy($id);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
