<?php

namespace App\Filters\Product;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class NameFilter extends FilterAbstract
{

    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);

        if ($value === null) {
            return $builder;
        }

        return $builder->where('name', 'like', '%' . $value[0] . '%');
    }
}
