<?php

namespace BenAllfree\Trackable\Helpers;

use BenAllfree\Trackable\Middleware\LogHit;

class Trackable 
{
  static function scripts()
  {
    $hit = LogHit::$hit;
    if(!$hit)
    {
      throw new Exception("Trackable scripts only work when 'trackable' middleware is enabled.");
    }
    $hit_id = $hit->id;
    $trackable_js_url = route('trackable.js');
    return <<<HTML
    <script>
      var Trackable = {hit_id: {$hit_id}};
    </script>
    <script src="$trackable_js_url" async></script>
HTML;
  }
}
