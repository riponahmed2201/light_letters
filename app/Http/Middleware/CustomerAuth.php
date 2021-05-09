<?php

namespace App\Http\Middleware;

use App\Models\Customer;
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

        if (session()->get('customer_id')) {
            $customer = Customer::where('id',session()->get('customer_id'))->first()->email;
            // dd($customer);
             if ($customer != null) {
                 return $next($request);
             }else{
                 return redirect('/');
             }
        }else{
            return redirect('/');
        }


        //return $next($request);
    }
}
