<?php

namespace BenAllfree\Trackable\Middleware;

use Closure;

class LogHit
{
  public static $hit = null;

    public function handle($request, Closure $next)
    {
      self::$hit = \Visitor::goal('hit');
      return $next($request);
    }
}
