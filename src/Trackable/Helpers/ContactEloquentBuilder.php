<?php

namespace BenAllfree\Trackable\Helpers;
  
class ContactEloquentBuilder extends \Illuminate\Database\Eloquent\Builder
{
  function whereMeta($k, $op, $v)
  {
    $this->query
      ->select('contacts.*')
      ->join('contact_metas', 'contact_metas.contact_id', '=', 'contacts.id')
      ->where('contact_metas.key', '=', $k)
      ->where('contact_metas.value', $op, $v)
      ->where('contact_metas.is_current', '=', 1)
    ;
    return $this;
  }
}