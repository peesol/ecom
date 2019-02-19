<?php

namespace App\Filters\Product;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class DiscountFilter extends FilterAbstract
{

    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);

        if ($value === null) {
            return $builder;
        }
        if ($value[0] == 'true') {
          return $builder->whereNotNull('discount_price');
        } else {
          return $builder->whereNull('discount_price');
        }
    }
}
