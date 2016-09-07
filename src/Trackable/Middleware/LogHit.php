<?php

namespace BenAllfree\Trackable\Middleware;

use Closure;

class LogHit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $h = \Visitor::goal('hit');
      session(['hit_id'=>$h->id]);
      return $next($request);
    }
}
