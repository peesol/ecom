<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
  protected $fillable = ['method', 'fee', 'multiply', 'promotion'];
  protected $casts = ['promotion' => 'array'];
  public $timestamps = false;
}
