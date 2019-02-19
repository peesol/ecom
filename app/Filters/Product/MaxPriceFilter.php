<?php

namespace App\Filters\Product;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class MaxPriceFilter extends FilterAbstract
{

    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);

        if ($value === null) {
            return $builder;
        }

        return $builder->where('price', '<=', $value);
    }
}
