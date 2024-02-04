<?php

namespace App\Http\Services\Animal;

use App\Models\FotoAnimal;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ErroGeralException;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Animal\StoreUpdateFotoAnimalRequest;

class FotoAnimalService
{

    protected $model;
    protected $formRequest;

    public function __construct()
    {
        $this->model = new FotoAnimal();
        $this->formRequest = new StoreUpdateFotoAnimalRequest();
    }

    public function index(string $idAnimal)
    {

        try {
            return $this->model
                ->where('id_animal', '=', $idAnimal)
                ->get();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function show(string $idAnimal, string $idFoto)
    {

        try {
            return $this->model->findOrFail($idFoto);
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function store($request)
    {

        $fotoAnimalDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            if (!$request->hasFile('imagens')) {
                throw new ErroGeralException('Sem arquivo');
            }

            $fotos = $fotoAnimalDados->validated()['imagens'];
            $idAnimal = $fotoAnimalDados->validated()['id_animal'];

            foreach ($fotos as $foto) {

                $animalsFotos = $this->model->create([
                    "nome_arquivo" => $foto->hashName(),
                    "nome_arquivo_original" => $foto->getClientOriginalName(),
                    "url" => $foto->store('animais/' . $idAnimal),
                    "id_animal" => $idAnimal
                ]);
            }

            DB::commit();

            return $this->model->where('id_animal', '=', $idAnimal)->get();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function update($request, $idAnimal)
    {

        $fotoAnimalDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            if (!$request->hasFile('imagens')) {
                throw new ErroGeralException('Sem arquivo');
            }

            $idAnimal = $fotoAnimalDados->validated()['id_animal'];

            $fotoAntigas = $this->model->whereIn('id_foto_animal', explode(",", $fotoAnimalDados->validated()['id_foto_animal']))->get();

            foreach ($fotoAntigas as $fotoAntiga) {
                Storage::disk('public')->delete(unlink($fotoAntiga->url));
            }

            $this->model->whereIn('id_foto_animal', explode(",", $fotoAnimalDados->validated()['id_foto_animal']))->delete();

            $fotosNovas = $fotoAnimalDados->validated()['imagens'];

            foreach ($fotosNovas as $fotosNova) {

                $this->model->create([
                    "nome_arquivo" => $fotosNova->hashName(),
                    "nome_arquivo_original" => $fotosNova->getClientOriginalName(),
                    "url" => $fotosNova->store('animais/' . $idAnimal),
                    "id_animal" => $idAnimal
                ]);
            }
            DB::commit();
            return $this->model->where('id_animal', '=', $idAnimal)->get();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function destroy($request, $idAnimal)
    {

        $fotoAnimalDados = app($this->formRequest::class, $request->toArray());

        DB::beginTransaction();

        try {

            $idAnimal = $fotoAnimalDados->validated()['id_animal'];

            $fotos = $this->model->whereIn('id_foto_animal', explode(",", $fotoAnimalDados->validated()['id_foto_animal']))->get();

            foreach ($fotos as $foto) {
                Storage::disk('public')->delete(unlink($foto->url));
            }

            $this->model->whereIn('id_foto_animal', explode(",", $fotoAnimalDados->validated()['id_foto_animal']))->delete();

            DB::commit();

            return $this->model->where('id_animal', '=', $idAnimal)->get();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
