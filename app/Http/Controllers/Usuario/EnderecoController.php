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
        try {
            return EnderecoResource::collection(
                $this->service->index($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function show(string $id)
    {
        try {
            return new EnderecoResource(
                $this->service->show($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store(Request $request)
    {
        // try {
        return new EnderecoResource(
            $this->service->store($request)
        );
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
    public function update(Request $request, string $id)
    {
        // try {
            return new EnderecoResource(
                $this->service->update($request, $id)
            );
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
    public function definirPrincipal(string $idUsuario, string $idEndereco)
    {
        try {
            return new EnderecoResource(
                $this->service->definirPrincipal($idUsuario, $idEndereco)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
