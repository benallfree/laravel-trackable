<?php
  
function goal($event_name, $data=[])
{
  \Action::goal(\Visitor::get()->id, $event_name, $data);
}
