<?php

namespace BenAllfree\Trackbale\Middleware;

use Closure;

use BenAllfree\Trackable\Models\Action;

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
      $h = Action::goal('hit');
      session(['hit_id'=>$h->id]);      
      
      return $next($request);
    }
}
