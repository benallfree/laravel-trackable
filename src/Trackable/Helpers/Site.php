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
    $s = \App\Site::whereHost($host)->first();
    if($s)
    {
      return self::$site = $s;
    }
    $regex = '/(.+)'.preg_quote('.'.env('HOST')).'/';
    preg_match($regex, $host, $matches);
    if(count($matches)<2)
    {
      abort(404);
    }
    $s = \App\Site::whereSlug($matches[1])->first();
    if(!$s)
    {
      abort(404);
    }
    return self::$site = $s;
  }
}
