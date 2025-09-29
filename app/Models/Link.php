<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
  protected $fillable = ['website', 'url', 'password'];
}
