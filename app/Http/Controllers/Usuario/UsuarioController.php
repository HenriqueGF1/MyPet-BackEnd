<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Usuario\UsuarioService;
use App\Http\Resources\Usuario\UsuarioResource;
use App\Http\Requests\Usuario\LoginUsuarioRequest;

class UsuarioController extends Controller
{

    protected $service;
    public function __construct()
    {
        $this->service = new UsuarioService();
    }
    public function show(string $id)
    {
        try {
            return new UsuarioResource(
                $this->service->show($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function checkToken()
    {
        try {
            return $this->service->checkToken();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function login(LoginUsuarioRequest $request)
    {
        try {
            return $this->service->login($request);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function logout()
    {
        try {
            return $this->service->logout();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store(Request $request)
    {
        // try {
            return $this->service->store(
                $request
            );
        // } catch (\Exception $exception) {
        //     throw new ErroGeralException($exception->getMessage());
        // }
    }
    public function update(Request $request, string $id)
    {
        try {
            return new UsuarioResource(
                $this->service->update(
                    $request,
                    $id
                )
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
