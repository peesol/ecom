<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
  protected $fillable = [ 'filename', 'product_id'];

  public $timestamps = false;

  public function product()
  {
    return $this->belingsTo(Product::class);
  }
}
