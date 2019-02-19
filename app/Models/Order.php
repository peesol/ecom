<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = [
    'user_id',
    'title',
    'uid',
    'body',
    'subtotal',
    'fee',
    'total',
    'discount',
    'shipping',
    'carrier',
    'tracking_number',
    'address',
    'date_paid',
    'status',
    'cancle',
  ];

  protected $casts = [
    'body' => 'array',
    'shipping' => 'array',
    'status' => 'array',
  ];

  public function getRouteKeyName()
  {
    return 'uid';
  }
}
