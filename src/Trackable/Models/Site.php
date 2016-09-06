<?php

namespace BenAllfree\Trackable\Models;

use Illuminate\Database\Eloquent\Model;
use BenAllfree\LaravelStaplerImages\AttachmentTrait;

class Site extends Model
{
  protected $fillable = ['host'];
}
