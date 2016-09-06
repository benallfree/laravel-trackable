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
}
