<?php

namespace BenAllfree\Trackable\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  protected $fillable = ['host'];
  
  function metas()
  {
    return $this->hasManyThrough(\ContactMeta::class, \Contact::class);
  }
  
  function currentMetas()
  {
    return $this->metas()->whereIsCurrent(true);
  }
  
  function contacts()
  {
    return $this->hasMany(\Contact::class);
  }
  
  function contactsWith($meta_key, $meta_value)
  {
    return $this->contacts()->whereMeta($meta_key, '=', $meta_value);
  }
}
