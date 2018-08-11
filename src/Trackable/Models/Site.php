<?php

namespace BenAllfree\Trackable\Models;

class Site extends \TrackableModelBase
{
  protected $fillable = ['host'];

  public function metas()
  {
    return $this->hasManyThrough(\ContactMeta::class, \Contact::class);
  }

  public function currentMetas()
  {
    return $this->metas()->whereIsCurrent(true);
  }

  public function contacts()
  {
    return $this->hasMany(\Contact::class);
  }

  public function contactsWith($meta_key, $meta_value)
  {
    return $this->contacts()->whereMeta($meta_key, '=', $meta_value);
  }
}
