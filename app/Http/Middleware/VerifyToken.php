<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->bearerToken();
            if ($token) {
                JWTAuth::setToken($token)->authenticate();
            }
        } catch (\Exception $exception) {
            if ($exception instanceof TokenInvalidException) {
                return response()->json(['message' => 'Token is invalid'], 401);
            } elseif ($exception instanceof TokenExpiredException) {
                return response()->json(['message' => 'Token is expired'], 401);
            } else {
                return response()->json(['message' => 'An error occurred'], 500);
            }
        }

        return $next($request);
    }
}
