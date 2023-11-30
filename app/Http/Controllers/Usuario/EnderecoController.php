<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exceptions\ErroGeralException;
use App\Http\Resources\Endereco\EnderecoResource;
use App\Services\Usuario\Endereco\EnderecoService;
use App\Http\Requests\Usuario\Endereco\StoreUpdateEnderecoRequest;


class EnderecoController extends Controller
{

    protected $service;
    protected $formRequest;

    public function __construct()
    {
        $this->service = new EnderecoService();
        $this->formRequest = new StoreUpdateEnderecoRequest();
    }
    public function index(string $id)
    {
        return EnderecoResource::collection(
            $this->service->index($id)
        );
    }
    public function show(string $id)
    {
        return new EnderecoResource(
            $this->service->show($id)
        );
    }
    public function store(Request $request)
    {
        return new EnderecoResource(
            $this->service->store($request)
        );
    }
    public function update(Request $request, string $id)
    {
        return new EnderecoResource(
            $this->service->update($request, $id)
        );
    }
    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }
    public function definirPrincipal(string $idUsuario, string $idEndereco)
    {
        return new EnderecoResource(
            $this->service->definirPrincipal($idUsuario, $idEndereco)
        );
    }
}
