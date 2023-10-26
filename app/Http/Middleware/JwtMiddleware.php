<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            // dd($user);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'code' => 498,
                    'status' => 'Token is Invalid'
                ]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(
                    [
                        'code' => 498,
                        'status' => 'Token is Expired'
                    ],
                );
            } else {
                return response()->json([
                    'code' => 401,
                    'status' => 'Authorization Token not found'
                ]);
            }
        }
        return $next($request);
    }
}
