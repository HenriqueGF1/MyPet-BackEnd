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
        return new UsuarioResource(
            $this->service->show($id)
        );
    }
    public function checkToken()
    {
        return $this->service->checkToken();
    }
    public function checkPerfil()
    {
        return $this->service->checkPerfil();
    }
    public function login(LoginUsuarioRequest $request)
    {
        return $this->service->login($request);
    }
    public function logout()
    {
        return $this->service->logout();
    }
    public function store(Request $request)
    {
        return $this->service->store(
            $request
        );
    }
    public function update(Request $request, string $id)
    {
        return new UsuarioResource(
            $this->service->update(
                $request,
                $id
            )
        );
    }
    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }
}
