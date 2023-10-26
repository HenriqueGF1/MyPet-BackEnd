<?php

namespace App\Services\Admin\Denuncia;

use App\Models\DenunciaAnimal;
use App\Models\DenunciaResposta;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use App\Services\Animal\AnimalService;
use App\Services\Usuario\UsuarioService;
use App\Http\Requests\Denuncia\StoreDenunciaRespostaRequest;
use App\Services\Denuncia\DenunciaAnimalService;

class DenunciaRespostaService
{

    private $model;
    protected $formRequest;
    public function __construct()
    {
        $this->model = new DenunciaResposta();
        $this->formRequest = new StoreDenunciaRespostaRequest();
    }
    public function index()
    {
        try {
            return $this->model->paginate();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function show(string $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function validarDenuncia($request)
    {

        $dadosRequest = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $dados = $dadosRequest->safe()->merge([
                "id_usuario" => UsuarioService::getIdUsuarioLoged()
            ]);

            $resposta = $this->model->create($dados->toArray());

            $this->verificarAceiteDenuncia(
                $dadosRequest->validated()['aceite'],
                $dadosRequest->validated()['id_denuncia'],
            );
            DB::commit();
            return $resposta;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function verificarAceiteDenuncia($aceite, $idDenuncia)
    {

        try {

            $dados = $this->model->with('denuncia')->whereIn('id_denuncia', [$idDenuncia])->get();

            $idAnimal = $dados[0]->denuncia->id_animal;
            // Desativar Animal e Denuncia
            if ($aceite == 1) {

                $animalService = new AnimalService();
                $animalService->desativarAnimal($idAnimal);

                $denunciaAnimalService = new DenunciaAnimalService();
                $denunciaAnimalService->desativarDenuncia($idDenuncia);
            } else {

                $animalService = new AnimalService();
                $animalService->retirarDenuncia($idAnimal);

                $denunciaAnimalService = new DenunciaAnimalService();
                $denunciaAnimalService->desativarDenuncia($idDenuncia);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
