<?php

namespace BenAllfree\Trackable\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  protected $fillable = ['site_id'];
  protected $_metas = [];
  protected $name;
  protected $email;

  function metas()
  {
    return $this->hasMany(ContactMeta::class);
  }
  
  function currentMetas()
  {
    return $this->metas()->whereIsCurrent(true);
  }
  
  function meta($meta_key)
  {
    if(isset($this->_metas[$meta_key])) return $this->_metas[$meta_key];
    $m = $this->metas()->whereKey($meta_key)->whereIsCurrent(true)->first();
    if(!$m)
    {
      return $this->_metas[$meta_key] = null;
    }
    return $this->_metas[$meta_key] = $m->value;
  }
  
  static function findByMeta($key, $value)
  {
    $m = ContactMeta::whereKey($key)->whereValue($value)->whereIsCurrent(true)->first();
    if(!$m) return null;
    $c = $m->contact;
    return $c;
  }
  
  function getEmailAttribute()
  {
    return $this->meta('email');
  }

  function getFirstNameAttribute()
  {
    return $this->meta('first_name');
  }
  
  function getSubscribedAttribute()
  {
    return $this->meta('subscribed');
  }
  function setSubscribedAttribute($v)
  {
    return $this->meta('subscribed',$v);
  }
  function getUuidAttribute()
  {
    return $this->meta('uuid');
  }
  
  function goal($event_name, $data = [])
  {
    return Action::goal($this->id, $event_name, $data);
  }
  
}
