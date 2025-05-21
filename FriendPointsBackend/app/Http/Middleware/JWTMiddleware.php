<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
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
        try{
            JWTAuth::parseToken()->authenticate();
        }catch(Exception $e){
            log::info("User is not authorised");
            // Return a json response saying the user is unauthorised
            return response()->json(["error" => "Unauthorised"], 401);
        }
        return $next($request);
    }
}
