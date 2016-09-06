<?php

namespace BenAllfree\Trackable\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
  protected $fillable = ['contact_id', 'event', 'ip_address', 'user_agent', 'referer', 'url', 'exited_at', 'request_method'];
  protected $dates = ['created_at', 'updated_at', 'exited_at'];
  
  static function goal($contact_id, $event, $data=[])
  {
    $a = self::create([
      'contact_id'=>$contact_id,
      'event'=>$event,
      'ip_address'=>\Request::server('REMOTE_ADDR'),
      'user_agent'=>\Request::server('HTTP_USER_AGENT'),
      'referer'=>\Request::server('HTTP_REFERER'),
      'url'=>\Request::url(),
      'request_method'=>\Request::server('REQUEST_METHOD'),
    ]);
    foreach($data as $k=>$v)
    {
      ActionMeta::create([
        'action_id'=>$a->id,
        'key'=>$k,
        'value'=>$v,
      ]);
    }
    return $a;
  }
}
