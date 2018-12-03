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
    'choice',
    'discount_price',
    'description',
    'visibility',
    'thumbnail',
  ];

  protected $casts = [
    'choice' => 'array'
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
    $data = [];
    foreach ($this->Images()->get() as $image) {
      $data[] = [
        'id' => $image->id,
        'filename' => config('app.url') . '/file/product/photo/' . $image->filename
      ];
    }
    return $data;
  }
  public function getThumbnail()
  {
    return config('app.url') . '/file/product/thumbnail/'. $this->thumbnail ;
  }
  public function scopeFilter(Builder $builder, Request $request, array $filters = [])
  {
    return (new ProductFilters(request()))->add($filters)->filter($builder);
  }
  public function getRouteKeyName()
  {
    return 'uid';
  }
}
