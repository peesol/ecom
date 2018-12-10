<?php

namespace App\Filters\Product;

use App\Filters\FiltersAbstract;

use App\Filters\Product\{
    CategoryFilter,
    SubategoryFilter,
    TypeFilter,
    PriceFilter
};

class ProductFilters extends FiltersAbstract
{
    /**
     * Default course filters.
     * Add query params alias here
     * @var array
     */
    protected $filters = [
      'name' => NameFilter::class,
      'order' => OrderByFilter::class,
      'c' => CategoryFilter::class,
      'sub' => SubcategoryFilter::class,
      'type' => TypeFilter::class,
      'min' => MinPriceFilter::class,
      'max' => MaxPriceFilter::class,
      'dc' => DiscountFilter::class,
    ];

}
