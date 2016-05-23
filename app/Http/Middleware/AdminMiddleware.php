<?php namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware {
    public function handle($request, Closure $next){
        if ( Auth::check() && Auth::user()->isAdmin()){
            return $next($request);
        } else {
            return Response('You are not supposed to be here !', 403);
        }
    }
}