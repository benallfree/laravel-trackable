<?php

namespace BenAllfree\Trackable\Helpers;
  
class ContactEloquentBuilder extends \Illuminate\Database\Eloquent\Builder
{
  function whereMeta($k, $op, $v)
  {
    $this->query
      ->select('contacts.*')
      ->join('contact_metas', 'contact_metas.contact_id', '=', 'contacts.id')
      ->where('contact_metas.key', '=', $meta_key)
      ->where('contact_metas.value', '=', $meta_value)
      ->where('contact_metas.is_current', $op, $v)
    ;
  }
}