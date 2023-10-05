<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CartMiddleware
{
  
    public function handle($request, Closure $next)
    {
       $qty = $request->route()->parameter['qty'];
       
      

       return $next($request);

    }
}
