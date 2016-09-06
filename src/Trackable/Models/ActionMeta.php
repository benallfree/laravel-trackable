<?php

namespace BenAllfree\Trackable\Models;

use Illuminate\Database\Eloquent\Model;

class ActionMeta extends Model
{
  protected $fillable = ['action_id', 'key', 'value'];
}
