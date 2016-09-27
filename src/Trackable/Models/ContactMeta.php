<?php

namespace BenAllfree\Trackable\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMeta extends Model
{
  protected $fillable = ['contact_id', 'key', 'value', 'is_current'];
  
  function contact()
  {
    return $this->belongsTo(Contact::class);
  }
}
