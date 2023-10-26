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
        try {
            return DenunciaTipoResource::collection(
                $this->service->index()
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            return new DenunciaTipoResource(
                $this->service->store($request)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            return new DenunciaTipoResource(
                $this->service->update($request, $id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return new DenunciaTipoResource(
                $this->service->destroy($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function inativar(string $id)
    {
        try {
            return new DenunciaTipoResource(
                $this->service->inativar($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function ativar(string $id)
    {
        try {
            return new DenunciaTipoResource(
                $this->service->ativar($id)
            );
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
