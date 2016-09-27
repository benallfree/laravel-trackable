<?php

namespace BenAllfree\Trackable\Helpers;

class Visitor 
{
  static $visitor;
  
  static function __callStatic($method, $args)
  {
    return call_user_func_array([self::get(), $method], $args);
  }
  
  static function get()
  {
    if(self::$visitor) return self::$visitor;
    return self::$visitor = \Contact::find(session('contact_id'));
  }

  static function check()
  {
    return self::get() != null;
  }
  
  static function transfer($new_contact)
  {
    if(!$new_contact)
    {
      throw new \Exception("New contact must not be null when transferring visitor to new contact.");
    }
    $current_contact = self::get();
    if($new_contact->id == $current_contact->id) return $current_contact;
    $new_contact->import($current_contact);
    \Action::whereContactId($current_contact->id)->update(['contact_id'=>$new_contact->id]);
    $current_contact->delete();
    session(['contact_id'=>$new_contact->id]);
    return self::$visitor = $new_contact;
  }
  
}
