<?php

namespace App\Http\Middleware;

use App\Models\Perfil_Usuario;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UsuarioAcesso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Perfil_Usuario::getIdUsuarioLoged() !== null) {

            $usuario = Perfil_Usuario::where('id_usuario', Perfil_Usuario::getIdUsuarioLoged())->whereIn('id_perfil', [1, 2])->orderBy('id_perfil', 'asc')->first();

            if (isset($usuario->id_perfil)) {

                if (Auth::check() && $usuario->id_perfil >= 1) {
                    return $next($request);
                }

            }

            return response()->json([
                'message' => 'Você não possui permissão',
                'code' => 401,
            ]);

        }

        // Auth::logout();
        return response()->json([
            'message' => 'Por favor, e necessário o login na plataforma novamente.',
            'code' => 401,
        ]);
    }
}
