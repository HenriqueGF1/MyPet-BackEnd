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
        return FavoritoAnimalResource::collection(
            $this->service->index()
        );
    }
    public function store(Request $request)
    {
        return new FavoritoAnimalResource(
            $this->service->store($request)
        );
    }
    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }
}
