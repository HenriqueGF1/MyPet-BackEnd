<?php

namespace App\Services\Animal;

use Carbon\Carbon;
use App\Models\Animal;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use Illuminate\Support\Facades\Storage;
use App\Services\Usuario\UsuarioService;
use App\Http\Requests\Animal\StoreUpdateAnimalRequest;

class AnimalService
{
    protected $model;
    protected $formRequest;
    public function __construct()
    {
        $this->model = new Animal();
        $this->formRequest = new StoreUpdateAnimalRequest();
    }
    public function index(): object
    {
        try {
            return $this->model->whereNull(
                'dt_inativacao'
            )->get();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function animaisUsuario(): object
    {
        try {
            return $this->model
                ->where(
                    'id_usuario',
                    '=',
                    UsuarioService::getIdUsuarioLoged()
                )->get();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function inativos(): object
    {
        try {
            return $this->model->whereNotNull(
                'dt_inativacao',
            )->where(
                'id_usuario',
                '=',
                UsuarioService::getIdUsuarioLoged()
            )->get();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function show(string $id): object
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function store($request)
    {

        $animalDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $validadosAnimal = $animalDados->safe()->merge([
                "id_usuario" => UsuarioService::getIdUsuarioLoged()
            ]);

            $animal = $this->model->create($validadosAnimal->toArray());

            $fotosAnimal = $validadosAnimal->imagens;

            foreach ($fotosAnimal as $foto) {

                $animal->fotos()->create([
                    "nome_arquivo" => $foto->hashName(),
                    "nome_arquivo_original" => $foto->getClientOriginalName(),
                    "url" => $foto->store('animais/' . $animal->id_animal),
                ]);
            }

            DB::commit();

            return $animal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function update($request, $id)
    {

        $animalDados = app($this->formRequest::class,  $request->toArray());

        DB::beginTransaction();

        try {
            $animal = $this->model->findOrFail($id);
            $animal->update($animalDados->validated());
            DB::commit();
            return $animal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function destroy($idAnimal)
    {

        DB::beginTransaction();

        try {

            $animal = $this->model->findOrFail($idAnimal);

            $animalFotos = $animal->with('fotos')->where(['id_animal' => $idAnimal])->get();

            foreach ($animalFotos[0]['fotos'] as $animalFoto) {
                Storage::disk('public')->delete($animalFoto->url);
            }

            $animal->fotos()->where(['id_animal' => $idAnimal])->delete();
            $animal->denuncias()->where(['id_animal' => $idAnimal])->delete();
            $animal->favoritos()->where(['id_animal' => $idAnimal])->delete();

            $animal = $this->model->findOrFail($idAnimal)->delete();

            DB::commit();
            return $animal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function desativarAnimal($id)
    {

        DB::beginTransaction();

        try {
            $animal = $this->model->findOrFail($id);
            $animal->dt_inativacao = Carbon::now();
            $animal->save();
            DB::commit();
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function ativarAnimal($id)
    {

        DB::beginTransaction();

        try {
            $animal = $this->model->findOrFail($id);
            $animal->dt_inativacao = null;
            $animal->save();
            DB::commit();
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function denunciado($idAnimal)
    {

        DB::beginTransaction();

        try {

            $animal = $this->model->findOrFail($idAnimal);

            $animal->qtd_denuncia = $animal->qtd_denuncia + 1;
            $animal->save();

            DB::commit();

            return $this->model->findOrFail($idAnimal);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function retirarDenuncia($idAnimal)
    {

        DB::beginTransaction();

        try {
            $animal = $this->model->findOrFail($idAnimal);

            $animal->qtd_denuncia = $animal->qtd_denuncia - 1;

            $animal->save();

            DB::commit();
            return $this->model->findOrFail($idAnimal);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function adotado($id, $request)
    {

        $validated = $request->validate([
            'adotado' => 'required|numeric|max:1',
        ]);

        DB::beginTransaction();

        try {
            $animal = $this->model->findOrFail($id);

            $animal->adotado = $validated['adotado'];

            $animal->save();

            DB::commit();
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
