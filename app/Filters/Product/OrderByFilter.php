<?php

namespace App\Filters\Product;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class OrderByFilter extends FilterAbstract
{

    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);

        if ($value === null) {
            return $builder;
        }

        if ($value[0] == 'min') {
          return $builder->orderBy('discount_price', 'asc')->orderBy('price', 'asc');
        } else {
          return $builder->orderBy('discount_price', 'desc')->orderBy('price', 'desc');
        }
    }
}
