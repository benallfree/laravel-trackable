<?php

namespace BenAllfree\Trackbale\Middleware;

use Closure;

use App\Helpers\Site;
use App\Domain;
use App\Contact;
use App\Variation;
use App\Helpers\Visitor;

class InitializeContact
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
      $uuid = $request->input('u');
      if($uuid)
      {
        $c = Contact::findByMeta('uuid', $uuid);
        if($c)
        {
          session('contact_id', $c->id);
        }
      }
      if(!session('contact_id') || !Visitor::check())
      {
        $c = Contact::create([
          'site_id'=>Site::get()->id,
        ]);
        session(['contact_id'=>$c->id]);
        Visitor::check();
      }
      
      return $next($request);
    }
}
