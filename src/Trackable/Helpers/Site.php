<?php

namespace BenAllfree\Trackable\Helpers;

class Site 
{
  static $site;
  static function get()
  {
    if(self::$site) return self::$site;
    $parts = parse_url(\Request::root());
    $host = $parts['host'];
    $s = \Site::whereHost($host)->first();
    if($s)
    {
      return self::$site = $s;
    }
    $s = \Site::create([
      'host'=>$host,
    ]);
    self::$site = $s;
    return self::$site;
  }
}
