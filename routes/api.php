<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Animal\AnimalController;
use App\Http\Controllers\Usuario\ContatoController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Usuario\EnderecoController;
use App\Http\Controllers\Animal\FotoAnimalController;
use App\Http\Controllers\Animal\FavoritoAnimalController;
use App\Http\Controllers\Denuncia\DenunciaAnimalController;
use App\Http\Controllers\Admin\Animal\PorteAnimalController;
use App\Http\Controllers\Admin\Denuncia\DenunciaTipoController;
use App\Http\Controllers\Admin\Animal\CategoriaAnimalController;
use App\Http\Controllers\Admin\Denuncia\DenunciaAdmController;
use App\Http\Controllers\Admin\Denuncia\DenunciaRespostaController;

// php artisan route:list --except-vendor
// php artisan clear-compiled
// composer dump-autoload
// php artisan optimize:clear

Route::get('/teste', [UsuarioController::class, 'index']);
//
Route::get('/animais', [AnimalController::class, 'index'])->name('animais.index');
//
Route::post('/create', [UsuarioController::class, 'store'])->name('usuario.store');
Route::post('/login', [UsuarioController::class, 'login'])->name('usuario.login');
//
Route::post('admin/login', [AdminController::class, 'login'])->name('adminLogin.login');

// ROTA DE ADMIN
Route::prefix('admin')->middleware(['admin.acesso'])->group(function () {

    Route::controller(AdminController::class)->group(function () {

        Route::get('/', 'index')->name('admin.index');
    });
    //
    Route::controller(PorteAnimalController::class)->group(function (): void {

        Route::get('/porteAnimais', 'indexADM')->name('porteAnimais.indexADM');
        //
        Route::get('/porteAnimais/{id}', 'show')->name('porteAnimais.show')
            ->where('id', '[0-9]+');
        //
        Route::post('/porteAnimais', 'store')->name('porteAnimais.store');
        //
        Route::patch('/porteAnimais/{id}', 'update')->name('porteAnimais.update')
            ->where('id', '[0-9]+');
        //
        Route::delete('/porteAnimais/{id}', 'destroy')->name('porteAnimais.destroy')
            ->where('id', '[0-9]+');
        //
        Route::patch('/porteAnimais/{id}/desativar', 'desativar')->name('porteAnimais.desativar')
            ->where('id', '[0-9]+');
        //
        Route::patch('/porteAnimais/{id}/ativar', 'ativar')->name('porteAnimais.ativar')
            ->where('id', '[0-9]+');
    });
    //
    Route::controller(CategoriaAnimalController::class)->group(function (): void {

        Route::get('/categoriasAnimal', 'indexADM')->name('categoriasAnimal.indexADM');
        //
        Route::get('/categoriasAnimal/{id}', 'show')->name('categoriasAnimal.show')
            ->where('id', '[0-9]+');
        //
        Route::post('/categoriasAnimal', 'store')->name('categoriasAnimal.store');
        //
        Route::patch('/categoriasAnimal/{id}', 'update')->name('categoriasAnimal.update')
            ->where('id', '[0-9]+');
        //
        Route::delete('/categoriasAnimal/{id}', 'destroy')->name('categoriasAnimal.destroy')
            ->where('id', '[0-9]+');
        //
        Route::patch('/categoriasAnimal/desativar/{id}', 'desativar')->name('categoriasAnimal.desativar')
            ->where('id', '[0-9]+');
        //
        Route::patch('/categoriasAnimal/ativar/{id}', 'ativar')->name('categoriasAnimal.ativar')
            ->where('id', '[0-9]+');
    });
    //
    Route::controller(DenunciaTipoController::class)->group(function (): void {

        Route::get('denuncias/tipos', 'index')->name('denunciaTipo.index');
        //
        Route::post('denuncias/tipos', 'store')->name('denunciaTipo.store');
        //
        Route::patch('denuncias/tipos/{idTipo}', 'update')->name('denunciaTipo.update')
            ->where('idTipo', '[0-9]+');
        //
        Route::delete('denuncias/tipos/{idTipo}', 'destroy')->name('denunciaTipo.destroy')
            ->where('idTipo', '[0-9]+');
        //
        Route::patch('denuncias/tipos/{idTipo}/inativar', 'inativar')->name('denunciaTipo.inativar')
            ->where('idTipo', '[0-9]+');
        //
        Route::patch('denuncias/tipos/{idTipo}/ativar', 'ativar')->name('denunciaTipo.ativar')
            ->where('idTipo', '[0-9]+');
    });
    //
    Route::controller(DenunciaAdmController::class)->group(function (): void {

        Route::get('denuncias', 'index')->name('adminDenuncia.index');
        //
        Route::get('denuncias/verificadas', 'verificadas')->name('adminDenuncia.verificadas');
        //
        Route::get('denuncias/retiradas', 'retiradas')->name('adminDenuncia.retiradas');
        //
        Route::get('denuncias/{idDenuncia}', 'show')->name('adminDenuncia.show')
            ->where('idDenuncia', '[0-9]+');
    });
    //
    Route::controller(DenunciaRespostaController::class)->group(function (): void {

        Route::get('denuncias/respostas', 'index')->name('denunciaResposta.index');
        //
        Route::get('denuncias/respostas/{idResposta}', 'show')->name('denunciaResposta.show')
            ->where('idDenuncia', '[0-9]+');
        //
        Route::post('denuncias/respostas', 'store')->name('denunciaResposta.store');
    });
});

// ROTA USUÁRIO
Route::middleware(['jwt.verify', 'usuario.acesso'])->group(function () {

    Route::controller(UsuarioController::class)->group(function () {

        Route::get('/checkToken', 'checkToken')
            ->name('usuario.checkToken');

        Route::get('/logout', 'logout')
            ->name('usuario.logout');;

        Route::get('/usuarios/{id}', 'show')
            ->name('usuario.show')
            ->where('id', '[0-9]+');

        Route::patch('/usuarios/{id}', 'update')
            ->name('usuario.update')
            ->where('id', '[0-9]+');

        Route::delete('/usuarios/{id}', 'destroy')
            ->name('usuario.destroy')
            ->where('id', '[0-9]+');
    });
    //
    Route::controller(PorteAnimalController::class)->group(function (): void {

        Route::get('/porteAnimais', 'index')->name('porteAnimais.index');
    });
    //
    Route::controller(CategoriaAnimalController::class)->group(function (): void {

        Route::get('/categoriasAnimal', 'index')->name('categoriasAnimal.index');
    });
    //
    Route::controller(ContatoController::class)->group(function () {

        Route::get('usuarios/{id}/contatos', 'index')->name('contato.index')
            ->where('id', '[0-9]+');
        //
        Route::get('/contatos/{id}', 'show')->name('contato.show')
            ->where('id', '[0-9]+');
        //
        Route::post('/contatos', 'store')->name('contato.store');
        //
        Route::patch('/usuarios/{idUsuario}/contatos/{idContato}/definirPrincipal', 'definirPrincipal')
            ->name('contato.definirPrincipal')
            ->where('idUsuario', '[0-9]+')
            ->where('idContato', '[0-9]+');
        //
        Route::patch('/contatos/{id}', 'update')
            ->name('contato.update')
            ->where('id', '[0-9]+');
        //
        Route::delete('/contatos/{id}', 'destroy')
            ->name('contato.destroy')
            ->where('id', '[0-9]+');
    });
    //
    Route::controller(AnimalController::class)->group(function (): void {

        Route::post('/animais', 'store')->name('animais.store');
        //
        Route::get('/animais/{id}', 'show')->name('animais.show')
            ->where('id', '[0-9]+');
        //
        Route::patch('/animais/{id}', 'update')->name('animais.update')
            ->where('id', '[0-9]+');
        // Deleta Permanentemente
        Route::delete('/animais/{id}', 'destroy')->name('animais.destroy')
            ->where('id', '[0-9]+');
        // Desativa
        Route::patch('/animais/desativar/{id}', 'desativarAnimal')->name('animais.desativarAnimal')
            ->where('id', '[0-9]+');
        // Ativar
        Route::patch('/animais/ativar/{id}', 'ativarAnimal')->name('animais.ativarAnimal')
            ->where('id', '[0-9]+');
        // Inativos
        Route::get('/animais/inativos', 'inativos')->name('animais.inativos');
        // Adotado
        Route::patch('/animais/{idAnimal}/adotado', 'adotado')->name('animais.adotado')
            ->where('id', '[0-9]+');
    });
    //
    Route::controller(FotoAnimalController::class)->group(function (): void {

        Route::get('/animais/{idAnimal}/fotos', 'index')->name('animaisFoto.index')
            ->where('idAnimal', '[0-9]+');
        //
        Route::get('/animais/{idAnimal}/fotos/{idFoto}', 'show')->name('animaisFoto.show')
            ->where('idAnimal', '[0-9]+')
            ->where('idFoto', '[0-9]+');
        //
        Route::post('/animais/fotos', 'store')->name('animaisFoto.store');
        //
        Route::post('/animais/{idAnimal}/fotos/atualizar', 'update')->name('animaisFoto.update')
            ->where('idAnimal', '[0-9]+');
        //
        Route::delete('/animais/fotos/{idFotoAnimal}', 'destroy')->name('animaisFoto.destroy')
            ->where('idFotoAnimal', '[0-9]+');
    });
    //
    Route::controller(EnderecoController::class)->group(function (): void {

        Route::get('usuarios/{id}/enderecos', 'index')->name('enderecos.index');
        //
        Route::get('/enderecos/{id}', 'show')->name('enderecos.show')
            ->where('id', '[0-9]+');
        //
        Route::post('/enderecos', 'store')->name('enderecos.store');
        //
        Route::patch('/enderecos/{id}', 'update')->name('enderecos.update')
            ->where('id', '[0-9]+');
        //
        Route::delete('/enderecos/{id}', 'destroy')->name('enderecos.destroy')
            ->where('id', '[0-9]+');
        //
        Route::patch('/usuarios/{idUsuario}/enderecos/{idEndereco}/definirPrincipal', 'definirPrincipal')
            ->name('enderecos.definirPrincipal')
            ->where('idUsuario', '[0-9]+')
            ->where('idEndereco', '[0-9]+');
    });
    //
    Route::controller(FavoritoAnimalController::class)->group(function (): void {

        Route::get('animais/favoritos', 'index')->name('animaisFavoritos.index');
        //
        Route::post('animais/favoritos', 'store')->name('animaisFavoritos.store');
        //
        Route::delete('/animais/favoritos/{id}', 'destroy')->name('animaisFavoritos.destroy')
            ->where('id', '[0-9]+');
    });
    //
    Route::controller(DenunciaAnimalController::class)->group(function (): void {

        Route::get('animais/denuncias', 'index')->name('animaisDenuncia.index');
        //
        Route::get('animais/denuncias/{id}', 'show')->name('animaisDenuncia.show')
            ->where('id', '[0-9]+');
        //
        Route::post('animais/denuncias', 'store')->name('animaisDenuncia.store');
        //
        Route::patch('animais/denuncias/{id}', 'update')->name('animaisDenuncia.update')
            ->where('id', '[0-9]+');
        //
        Route::patch('animais/retirarDenuncia/{id}', 'retirarDenuncia')->name('animaisDenuncia.retirarDenuncia')
            ->where('id', '[0-9]+');
    });
});

Route::fallback(function () {
    return "Erro na rota !!!";
});
