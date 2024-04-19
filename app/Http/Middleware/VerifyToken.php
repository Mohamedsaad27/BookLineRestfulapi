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
            $token = $request->token;
            if($token){
              $user = JWTAuth::parseToken()->authenticate();
            }
        }catch (\Exception $exception){
            if ($exception instanceof TokenInvalidException){
                return response()->json(['message'=>'Token Is Invalid']);
            }
            elseif ($exception instanceof TokenExpiredException){
                return response()->json(['message'=>'Token Is expired']);
            }
            else{
                return response()->json(['message'=>'another exception']);
            }
        }
        return $next($request);
    }
}
