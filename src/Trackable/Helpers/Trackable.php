<?php

namespace BenAllfree\Trackable\Helpers;

use BenAllfree\Trackable\Middleware\LogHit;

class Trackable 
{
  static function scripts()
  {
    $hit_id = LogHit::$hit->id;
    $trackable_js_url = route('trackable.js');
    return <<<HTML
    <script>
      var Trackable = {hit_id: {$hit_id}};
    </script>
    <script src="$trackable_js_url" async></script>
HTML;
  }
}
