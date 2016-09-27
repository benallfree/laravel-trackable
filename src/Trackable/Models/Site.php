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
    return $this->hasMany(Contact::class);
  }
  
  function contactsWith($meta_key, $meta_value)
  {
    return $this->contacts()
      ->select('contacts.*')
      ->join('contact_metas', 'contact_metas.contact_id', '=', 'contacts.id')
      ->where('contacts.site_id', '=', $this->id)
      ->where('contact_metas.key', '=', $meta_key)
      ->where('contact_metas.value', '=', $meta_value)
      ->where('contact_metas.is_current', '=', 1);
  }
}
