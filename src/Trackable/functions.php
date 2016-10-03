<?php
  
function goal($event_name, $data=[])
{
  \Action::goal(\Visitor::get(), $event_name, $data);
}
