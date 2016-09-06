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
    return $this->hasMany(\ContactMeta::class);
  }
  
  function currentMetas()
  {
    return $this->metas()->whereIsCurrent(true);
  }
  
  function meta($meta_key, $meta_value=null)
  {
    if(is_array($meta_key))
    {
      foreach($meta_key as $k=>$v)
      {
        $this->meta($k, $v);
      }
      return $meta_key;
    }
    
    // Get the meta value
    if($meta_value===null)
    {
      if(isset($this->_metas[$meta_key])) return $this->_metas[$meta_key];
      $m = $this->currentMetas()->whereKey($meta_key)->first();
      if(!$m)
      {
        return $this->_metas[$meta_key] = null;
      }
      return $this->_metas[$meta_key] = $m->value;
    }
    
    // Set the meta value
    if($this->meta($meta_key)==$meta_value) return $meta_value;
    $this->currentMetas()->whereKey($meta_key)->update(['is_current'=>false]);
    $m = \ContactMeta::create([
      'contact_id'=>$this->id, 
      'key'=>$meta_key, 
      'value'=>$meta_value,
      'is_current'=>true,
    ]);
    $this->_metas[$meta_key] = $m;
    return $m->value;
  }
  
  static function findByMeta($key, $value)
  {
    $m = \ContactMeta::whereKey($key)->whereValue($value)->whereIsCurrent(true)->first();
    if(!$m) return null;
    $c = $m->contact;
    return $c;
  }
  
  function toArray()
  {
    $data = $this->currentMetas()->get()->pluck('value', 'key')->toArray();
    $data['id'] = $this->id;
    return $data;
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
    return \Action::goal($this->id, $event_name, $data);
  }
  
}
