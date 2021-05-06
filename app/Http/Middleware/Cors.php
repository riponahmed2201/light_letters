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
//         $next($request)
//            ->header('Access-Control-Allow-Origin','*')
//            ->header('Access-Control-Allow-Methods', 'PUT, POST, PATCH, DELETE, GET, OPTIONS')
//            ->header('Access-Control-Allow-Headers', 'Accept, Authorization, Content-Type, Origin, X-Request-With, X-Requested-With, x-client-key, x-client-token, x-client-secret, X-PINGOTHER')
//            ->header('Access-Control-Allow-Credentials', 'true')
//            ->header('Access-Control-Max-Age', 86400);

        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'PUT, POST, PATCH, DELETE, GET, OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Accept, Content-Type, Authorization, Origin, X-Requested-With, X-Request-With, x-client-key, x-client-token, x-client-secret, X-PINGOTHER'
        ];
        $response = $next($request);
        foreach($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        return $response;
    }
}
