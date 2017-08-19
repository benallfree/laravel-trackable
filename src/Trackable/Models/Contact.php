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
      $m = $this->currentMetas()->where("key", "=", $meta_key)->first();
      if(!$m)
      {
        return $this->_metas[$meta_key] = null;
      }
      return $this->_metas[$meta_key] = $m;
    }

    // Set the meta value
    if($this->metav($meta_key)===$meta_value) return $meta_value;
    $this->currentMetas()->where("key", "=", $meta_key)->update(['is_current'=>false]);
    $m = \ContactMeta::create([
      'contact_id'=>$this->id, 
      'key'=>$meta_key, 
      'value'=>$meta_value,
      'is_current'=>true,
    ]);
    $this->_metas[$meta_key] = $m;
    return $m;
  }
  
  function metav($meta_key, $meta_value=null)
  {
    $m = $this->meta($meta_key, $meta_value);
    return $m ? $m->value : null;
  }
  
  static function findByMeta($key, $value)
  {
    return Contact::whereMeta($key, '=', $value)->whereIsCurrent(true)->first();
  }
  
  function toArray()
  {
    $data = $this->currentMetas()->get()->pluck('value', 'key')->toArray();
    $data['id'] = $this->id;
    return $data;
  }
  
  function getUuidAttribute()
  {
    $v = $this->metav('uuid');
    if($v) return $v;
    
    $uuid = sprintf("%d-%s", $this->id, uniqid());
    $this->meta('uuid', $uuid);
    
    return $uuid;
  }
  
  function goal($event_name, $data = [])
  {
    return \Action::goal($this->id, $event_name, $data);
  }
  
  function actions()
  {
    return $this->hasMany(\Action::class);
  }
  
  public function newEloquentBuilder($query)
  {
    return new \BenAllfree\Trackable\Helpers\ContactEloquentBuilder($query);
  }
  
  function importAndDelete($src_contact)
  {
    $target_contact = $this;
    $f = function() use($src_contact, $target_contact) {
      $sql = "
        update contact_metas src join contact_metas dst on
            src.contact_id = {$src_contact->id} 
          and 
            dst.contact_id = {$target_contact->id} 
          and 
            src.key = dst.key 
          and
            src.is_current=1 
          and
            dst.is_current=1
          set 
            src.is_current = src.created_at > dst.created_at,
            dst.is_current = src.created_at <= dst.created_at
      ";
      \DB::statement(\DB::raw($sql));
      \Action::whereContactId($src_contact->id)->update(['contact_id'=>$target_contact->id]);
      $src_contact->metas()->update(['contact_id'=>$target_contact->id]);
      $src_contact->delete();
    };
    \DB::transaction($f);
  }
}
