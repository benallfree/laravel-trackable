<?php

namespace BenAllfree\Trackable\Middleware;

use Closure;

use BenAllfree\Trackable\Helpers\Visitor;

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
      $h = Visitor::get()->goal('hit');
      $s = app('session');
      $s->set('hit_id', $h->id);
      return $next($request);
    }
}
