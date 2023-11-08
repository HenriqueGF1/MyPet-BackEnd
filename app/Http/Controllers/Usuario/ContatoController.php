<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Http\Resources\Contato\ContatoResource;
use App\Services\Usuario\Contato\ContatoService;


class ContatoController extends Controller
{

    protected $service;
    public function __construct()
    {
        $this->service = new ContatoService();
    }

    public function index(): object
    {
        try {
            return ContatoResource::collection($this->service->index());
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function show(string $id): object
    {
        try {
            return new ContatoResource($this->service->show($id));
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function store(Request $request)
    {
        // try {
        return new ContatoResource($this->service->store($request));
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
    public function definirPrincipal(string $idUsuario, string $idContato)
    {
        try {
            return new ContatoResource($this->service->definirPrincipal($idUsuario, $idContato));
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function update(Request $request, string $id)
    {
        // try {
        return new ContatoResource($this->service->update($request, $id));
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
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
