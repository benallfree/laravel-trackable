<?php

namespace BenAllfree\Trackable\Helpers;

use \BenAllfree\Trackable\Models\Site as SiteModel;

class Site 
{
  static $site;
  static function get()
  {
    if(self::$site) return self::$site;
    $parts = parse_url(\Request::root());
    $host = $parts['host'];
    $s = SiteModel::whereHost($host)->first();
    if($s)
    {
      return self::$site = $s;
    }
    $s = SiteModel::create([
      'host'=>$host,
    ]);
    self::$site = $s;
    return self::$site;
  }
}
