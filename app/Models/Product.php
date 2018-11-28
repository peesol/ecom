<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Product\ProductFilters;

class Product extends Model
{
  protected $fillable = [
    'uid',
    'name',
    'category_id',
    'subcategory_id',
    'price',
    'discount_price',
    'description',
    'visibility',
    'thumbnail',
  ];
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
  public function subcategory()
  {
    return $this->belongsTo(Subcategory::class);;
  }
  public function images()
  {
    return $this->hasMany(ProductImage::class);
  }
  public function getImage()
  {
    return config('app.url') . 'app/public/product/photo/' . $this->Images->select('filename')->get();
  }
  public function getThumbnail()
  {
    return config('app.url') . '/file/product/thumbnail/'. $this->thumbnail ;
  }
  public function scopeFilter(Builder $builder, Request $request, array $filters = [])
  {
    return (new ProductFilters(request()))->add($filters)->filter($builder);
  }
}
