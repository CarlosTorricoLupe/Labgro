<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $headers = [
            'Access-Control-Allow-Origin'=>'*',
            'Access-Control-Allow-Methods'=>'GET, POST, PUT, DELETE',
            "Access-Control-Allow-Headers"=>'X-Requested-With, Content-Type, X-Token-Auth, Authorization, Accept, Application'
        ];
        
        foreach($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
