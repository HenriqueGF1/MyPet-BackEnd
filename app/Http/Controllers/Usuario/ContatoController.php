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
        return ContatoResource::collection($this->service->index());
    }

    public function show(string $id): object
    {
        return new ContatoResource($this->service->show($id));
    }

    public function store(Request $request)
    {
        return new ContatoResource($this->service->store($request));
    }
    public function definirPrincipal(string $idUsuario, string $idContato)
    {
        return new ContatoResource($this->service->definirPrincipal($idUsuario, $idContato));
    }
    public function update(Request $request, string $id)
    {
        return new ContatoResource($this->service->update($request, $id));
    }
    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }
}
