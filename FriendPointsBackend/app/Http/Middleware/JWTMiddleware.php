<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Try to parse the users JWT
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            log::info("Token has expired");
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            log::info("Token is invalid");
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (JWTException $e) {
            log::info("Token not found or malformed");
            return response()->json(['error' => 'Token not found or malformed'], 401);
        }
        return $next($request);
    }
}
