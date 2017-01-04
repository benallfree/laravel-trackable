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
    self::$visitor = \Contact::find(session('contact_id'));
    return self::$visitor;
  }

  static function check()
  {
    return self::get() != null;
  }
  
  static function transfer($target_contact)
  {
    if(!$target_contact)
    {
      throw new \Exception("Target contact must not be null when transferring visitor to another contact.");
    }
    $src_contact = self::get();
    if($target_contact->id == $src_contact->id) return $src_contact;
    $target_contact->importAndDelete($src_contact);
    session(['contact_id'=>$target_contact->id]);
    return self::$visitor = $target_contact;
  }
  
}
