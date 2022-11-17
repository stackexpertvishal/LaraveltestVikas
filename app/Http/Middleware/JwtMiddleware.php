<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Traits\ApiResponseTrait;

class JwtMiddleware extends BaseMiddleware
{

    use ApiResponseTrait;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) 
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } 
        catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->errorResponse('Token is Invalid', 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->errorResponse('Token is Expired', 401);
            }else{
                return $this->errorResponse('Authorization Token not found', 401);
            }
        }
        return $next($request);
    }
}
