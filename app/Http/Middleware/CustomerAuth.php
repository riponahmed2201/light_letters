<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerAuth
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
//        $customer = session('customer_id');
//        if (empty($customer)){
//            return route('login-page');
//        }3
//        echo $request->path();
//        $path = $request->path();
//        if (($path==''||$path=='welcome'||$path=='sign_up') && session()->has('customer_id')){
//            return redirect('/home');
//        }


        return $next($request);
    }
}
