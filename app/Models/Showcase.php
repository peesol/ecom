<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showcase extends Model
{
  protected $fillable = ['name', 'show', 'order'];

  public function products()
  {
    return $this->belongsToMany(Product::class, 'showcase_products');
  }

}
