<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
  protected $fillable =['name', 'translation'];
  public $timestamps = false;

  public function category()
  {
    return $this->belongsTo(Category::class) ;
  }

  public function product()
  {
    return $this->hasMany(Product::class);
  }
}
