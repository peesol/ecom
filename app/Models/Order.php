<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillabel = [
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
}
