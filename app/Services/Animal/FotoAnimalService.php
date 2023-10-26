<?php

namespace App\Services\Animal;

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
                ->paginate();
        } catch (\Exception $exception) {
            throw new ErroGeralException($exception->getMessage());
        }
    }
    public function show(string $idAnimal, string $idFoto)
    {
        // return $this->model->where('id_animal', '=', $idAnimal)->where('id_foto_animal', '=', $idFoto)->get();
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

            $fotos = $fotoAnimalDados->validated()['imagens'];

            $idAnimal = $fotoAnimalDados->validated()['id_animal'];

            foreach ($fotos as $foto) {

                $animalsFotos = $this->model->create([
                    "nome_arquivo" => $foto->hashName(),
                    "nome_arquivo_original" => $foto->getClientOriginalName(),
                    "url" => $foto->store('animais/' . $idAnimal, 'public'),
                    "id_animal" => $idAnimal
                ]);
            }

            DB::commit();

            return $this->model->where('id_animal', '=', $idAnimal)->paginate();
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

            $idAnimal = $fotoAnimalDados->validated()['id_animal'];


            $fotoAntigas = $this->model->whereIn('id_foto_animal', explode(",", $fotoAnimalDados->validated()['id_foto_animal']))->get();

            foreach ($fotoAntigas as $fotoAntiga) {
                Storage::disk('public')->delete($fotoAntiga->url);
            }

            $this->model->whereIn('id_foto_animal', explode(",", $fotoAnimalDados->validated()['id_foto_animal']))->delete();

            $fotosNovas = $fotoAnimalDados->validated()['imagens'];

            foreach ($fotosNovas as $fotosNova) {

                $this->model->create([
                    "nome_arquivo" => $fotosNova->hashName(),
                    "nome_arquivo_original" => $fotosNova->getClientOriginalName(),
                    "url" => $fotosNova->store('animais/' . $idAnimal, 'public'),
                    "id_animal" => $idAnimal
                ]);
            }
            DB::commit();
            return $this->model->where('id_animal', '=', $idAnimal)->paginate();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }

    public function destroy($idFotoAnimal)
    {

        DB::beginTransaction();

        try {

            $foto = $this->model->findOrFail($idFotoAnimal);

            Storage::disk('public')->delete($foto->url);

            $fotoAnimal = $this->model->findOrFail($idFotoAnimal)->delete();

            DB::commit();
            return $fotoAnimal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ErroGeralException($exception->getMessage());
        }
    }
}
