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

//Outras
Route::get('/checkPerfil', [UsuarioController::class, 'checkPerfil'])->name('usuario.checkPerfil');

// ANIMAL
Route::get('/animais', [AnimalController::class, 'index'])->name('animais.index');

// USUÁRIO
Route::post('/create', [UsuarioController::class, 'store'])->name('usuario.store');
Route::post('/login', [UsuarioController::class, 'login'])->name('usuario.login');

// ADM
Route::post('admin/login', [AdminController::class, 'login'])->name('adminLogin.login');

// ROTA DE ADMIN
Route::prefix('admin')->middleware(['admin.acesso'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'index')->name('admin.index');
    });

    // ADMIN PORTE_ANIMAL
    Route::controller(PorteAnimalController::class)->group(function (): void {
        Route::get('/porteAnimais', 'indexADM')->name('admPorteAnimais.indexADM');
        //
        Route::get('/porteAnimais/{id}', 'show')->name('admPorteAnimais.show')
            ->where('id', '[0-9]+');
        //
        Route::post('/porteAnimais', 'store')->name('admPorteAnimais.store');
        //
        Route::patch('/porteAnimais/{id}', 'update')->name('admPorteAnimais.update')
            ->where('id', '[0-9]+');
        //
        Route::delete('/porteAnimais/{id}', 'destroy')->name('admPorteAnimais.destroy')
            ->where('id', '[0-9]+');
        //
        Route::patch('/porteAnimais/{id}/desativar', 'desativar')->name('admPorteAnimais.desativar')
            ->where('id', '[0-9]+');
        //
        Route::patch('/porteAnimais/{id}/ativar', 'ativar')->name('admPorteAnimais.ativar')
            ->where('id', '[0-9]+');
    });

    // ADMIN CATEGORIA_ANIMAL
    Route::controller(CategoriaAnimalController::class)->group(function (): void {
        Route::get('/categoriasAnimal', 'indexADM')->name('admCategoriasAnimal.indexADM');
        //
        Route::get('/categoriasAnimal/{id}', 'show')->name('admCategoriasAnimal.show')
            ->where('id', '[0-9]+');
        //
        Route::post('/categoriasAnimal', 'store')->name('admCategoriasAnimal.store');
        //
        Route::patch('/categoriasAnimal/{id}', 'update')->name('admCategoriasAnimal.update')
            ->where('id', '[0-9]+');
        //
        Route::delete('/categoriasAnimal/{id}', 'destroy')->name('admCategoriasAnimal.destroy')
            ->where('id', '[0-9]+');
        //
        Route::patch('/categoriasAnimal/desativar/{id}', 'desativar')->name('admCategoriasAnimal.desativar')
            ->where('id', '[0-9]+');
        //
        Route::patch('/categoriasAnimal/ativar/{id}', 'ativar')->name('admCategoriasAnimal.ativar')
            ->where('id', '[0-9]+');
    });

    // ADMIN DENUNCIA_TIPO
    Route::controller(DenunciaTipoController::class)->group(function (): void {
        //
        Route::get('denuncias/tipos', 'indexADM')->name('admDenunciaTipo.index');
        //
        Route::post('denuncias/tipos', 'store')->name('admDenunciaTipo.store');
        //
        Route::patch('denuncias/tipos/{idTipo}', 'update')->name('admDenunciaTipo.update')
            ->where('idTipo', '[0-9]+');
        //
        Route::delete('denuncias/tipos/{idTipo}', 'destroy')->name('admDenunciaTipo.destroy')
            ->where('idTipo', '[0-9]+');
        //
        Route::patch('denuncias/tipos/{idTipo}/inativar', 'inativar')->name('admDenunciaTipo.inativar')
            ->where('idTipo', '[0-9]+');
        //
        Route::patch('denuncias/tipos/{idTipo}/ativar', 'ativar')->name('admDenunciaTipo.ativar')
            ->where('idTipo', '[0-9]+');
    });

    // ADMIN DENUNCIA_ADM
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

    // ADMIN DENUNCIA_RESPOSTA
    Route::controller(DenunciaRespostaController::class)->group(function (): void {
        Route::get('denuncias/respostas', 'index')->name('admDenunciaResposta.index');
        //
        Route::get('denuncias/respostas/{idResposta}', 'show')->name('admDenunciaResposta.show')
            ->where('idDenuncia', '[0-9]+');
        //
        Route::post('denuncias/respostas', 'store')->name('admDenunciaResposta.store');
    });
});

// ROTA USUÁRIO
Route::middleware(['jwt.verify', 'usuario.acesso'])->group(function () {

    // USUÁRIO
    Route::controller(UsuarioController::class)->group(function () {
        Route::get('/checkToken', 'checkToken')
            ->name('usuario.checkToken');
        //
        Route::get('/logout', 'logout')
            ->name('usuario.logout');;
        //
        Route::get('/usuarios/{id}', 'show')
            ->where('id', '[0-9]+')
            ->name('usuario.show');
        //
        Route::patch('/usuarios/{id}', 'update')
            ->where('id', '[0-9]+')
            ->name('usuario.update');
        //
        Route::delete('/usuarios/{id}', 'destroy')
            ->where('id', '[0-9]+')
            ->name('usuario.destroy');
    });

    // USUÁRIO CONTATO
    Route::controller(ContatoController::class)->group(function () {
        Route::get('usuarios/{id}/contatos', 'index')
            ->where('id', '[0-9]+')
            ->name('contato.index');
        //
        Route::get('/contatos/{id}', 'show')
            ->where('id', '[0-9]+')
            ->name('contato.show');
        //
        Route::post('/contatos', 'store')->name('contato.store');
        //
        Route::patch('/usuarios/{idUsuario}/contatos/{idContato}/definirPrincipal', 'definirPrincipal')
            ->where('idUsuario', '[0-9]+')
            ->where('idContato', '[0-9]+')
            ->name('contato.definirPrincipal');
        //
        Route::patch('/contatos/{id}', 'update')
            ->where('id', '[0-9]+')
            ->name('contato.update');
        //
        Route::delete('/contatos/{id}', 'destroy')
            ->where('id', '[0-9]+')
            ->name('contato.destroy');
    });

    // USUÁRIO ANIMAL
    Route::controller(AnimalController::class)->group(function (): void {
        Route::get('usuario/animais', [AnimalController::class, 'animaisUsuario'])
            ->name('animais.animaisUsuario');
        //
        Route::post('/animais', 'store')
            ->name('animais.store');
        //
        Route::get('/animais/{id}', 'show')
            ->where('id', '[0-9]+')
            ->name('animais.show');
        //
        Route::patch('/animais/{id}', 'update')
            ->where('id', '[0-9]+')
            ->name('animais.update');
        // Deleta Permanentemente
        Route::delete('/animais/{id}', 'destroy')
            ->where('id', '[0-9]+')
            ->name('animais.destroy');
        // Desativa
        Route::patch('/animais/desativar/{id}', 'desativarAnimal')
            ->where('id', '[0-9]+')
            ->name('animais.desativarAnimal');
        // Ativar
        Route::patch('/animais/ativar/{id}', 'ativarAnimal')
            ->where('id', '[0-9]+')
            ->name('animais.ativarAnimal');
        // Inativos
        Route::get('/animais/inativos', 'inativos')
            ->name('animais.inativos');
        // Adotado
        Route::patch('/animais/{idAnimal}/adotado', 'adotado')
            ->where('id', '[0-9]+')
            ->name('animais.adotado');
    });

    // USUÁRIO FOTO_ANIMAL
    Route::controller(FotoAnimalController::class)->group(function (): void {

        Route::get('/animais/{idAnimal}/fotos', 'index')
            ->where('idAnimal', '[0-9]+')
            ->name('animaisFoto.index');
        //
        Route::get('/animais/{idAnimal}/fotos/{idFoto}', 'show')
            ->where('idAnimal', '[0-9]+')
            ->where('idFoto', '[0-9]+')
            ->name('animaisFoto.show');
        //
        Route::post('/animais/fotos', 'store')
            ->name('animaisFoto.store');
        //
        Route::post('/animais/{idAnimal}/fotos/atualizar', 'update')
            ->where('idAnimal', '[0-9]+')
            ->name('animaisFoto.update');
        //
        Route::delete('/animais/fotos/{idFotoAnimal}', 'destroy')
            ->where('idFotoAnimal', '[0-9]+')
            ->name('animaisFoto.destroy');
    });

    // USUÁRIO ENDEREÇO
    Route::controller(EnderecoController::class)->group(function (): void {
        Route::get('usuarios/{id}/enderecos', 'index')
            ->name('enderecos.index');
        //
        Route::get('/enderecos/{id}', 'show')
            ->where('id', '[0-9]+')
            ->name('enderecos.show');
        //
        Route::post('/enderecos', 'store')
            ->name('enderecos.store');
        //
        Route::patch('/enderecos/{id}', 'update')
            ->where('id', '[0-9]+')
            ->name('enderecos.update');
        //
        Route::delete('/enderecos/{id}', 'destroy')
            ->where('id', '[0-9]+')
            ->name('enderecos.destroy');
        //
        Route::patch('/usuarios/{idUsuario}/enderecos/{idEndereco}/definirPrincipal', 'definirPrincipal')
            ->where('idUsuario', '[0-9]+')
            ->where('idEndereco', '[0-9]+')
            ->name('enderecos.definirPrincipal');
    });

    // USUÁRIO FAVORITO_ANIMAL
    Route::controller(FavoritoAnimalController::class)->group(function (): void {
        Route::get('animais/favoritos', 'index')
            ->name('animaisFavoritos.index');
        //
        Route::post('animais/favoritos', 'store')
            ->name('animaisFavoritos.store');
        //
        Route::delete('/animais/favoritos/{id}', 'destroy')
            ->where('id', '[0-9]+')
            ->name('animaisFavoritos.destroy');
    });

    // USUÁRIO DENUNCIA_ANIMAL
    Route::controller(DenunciaAnimalController::class)->group(function (): void {
        Route::get('animais/denuncias', 'index')
            ->name('animaisDenuncia.index');
        //
        Route::get('animais/denuncias/{id}', 'show')
            ->where('id', '[0-9]+')
            ->name('animaisDenuncia.show');
        //
        Route::post('animais/denuncias', 'store')
            ->name('animaisDenuncia.store');
        //
        Route::patch('animais/denuncias/{id}', 'update')
            ->where('id', '[0-9]+')
            ->name('animaisDenuncia.update');
        //
        Route::patch('animais/retirarDenuncia/{id}', 'retirarDenuncia')
            ->where('id', '[0-9]+')
            ->name('animaisDenuncia.retirarDenuncia');
    });

    // Combos

    Route::controller(PorteAnimalController::class)->group(function (): void {
        Route::get('/porteAnimais', 'index')->name('porteAnimais.index');
    });

    Route::controller(CategoriaAnimalController::class)->group(function (): void {
        Route::get('/categoriasAnimal', 'index')->name('categoriasAnimal.index');
    });

    Route::controller(DenunciaTipoController::class)->group(function (): void {
        Route::get('denuncias/tipos', 'index')->name('denunciaTipo.index');
    });
});

Route::fallback(function () {
    return "Erro na rota !!!";
});
