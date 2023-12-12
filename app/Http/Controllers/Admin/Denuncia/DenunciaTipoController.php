<?php

namespace App\Http\Controllers\Admin\Denuncia;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ErroGeralException;
use App\Services\Admin\Denuncia\DenunciaTipoService;
use App\Http\Resources\Denuncia\DenunciaTipoResource;

class DenunciaTipoController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new DenunciaTipoService();
    }
    public function index()
    {
        return DenunciaTipoResource::collection(
            $this->service->index()
        );
    }
    public function indexADM()
    {
        return DenunciaTipoResource::collection(
            $this->service->indexADM()
        );
    }
    public function show(string $id)
    {
        return new DenunciaTipoResource(
            $this->service->show($id)
        );
    }
    public function store(Request $request)
    {
        return new DenunciaTipoResource(
            $this->service->store($request)
        );
    }
    public function update(Request $request, string $id)
    {
        return new DenunciaTipoResource(
            $this->service->update($request, $id)
        );
    }
    public function destroy(string $id)
    {
        return new DenunciaTipoResource(
            $this->service->destroy($id)
        );
    }
    public function inativar(string $id)
    {
        return new DenunciaTipoResource(
            $this->service->inativar($id)
        );
    }
    public function ativar(string $id)
    {
        return new DenunciaTipoResource(
            $this->service->ativar($id)
        );
    }
}
