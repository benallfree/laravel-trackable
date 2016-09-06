<?php

namespace BenAllfree\Trackable\Helpers;

use  BenAllfree\Trackable\Contact;
use  BenAllfree\Trackable\ContactMeta;
use  BenAllfree\Trackable\Action;

class Visitor 
{
  static $visitor;
  static function get()
  {
    if(self::$visitor) return self::$visitor;
    return self::$visitor = Contact::find(session('contact_id'));
  }

  static function check()
  {
    return self::get() != null;
  }
  
  static function transfer($new_contact)
  {
    $current_contact = self::get();
    if($new_contact->id == $current_contact->id) return;
    $new_contact->import($current_contact);
    Action::whereContactId($current_contact->id)->update(['contact_id'=>$new_contact->id]);
    $current_contact->delete();
    session(['contact_id'=>$new_contact->id]);
    return self::$visitor = $new_contact;
  }
  
}
