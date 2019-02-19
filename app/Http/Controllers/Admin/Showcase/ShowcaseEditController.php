<?php

namespace App\Http\Controllers\Admin\Showcase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Showcase, ShowcaseProduct, Product};

class ShowcaseEditController extends Controller
{
  public function update(Showcase $showcase, Request $request)
  {
    $showcase->update([
      'name' => $request->name,
    ]);

    return ;
  }

  public function storeProduct(Showcase $showcase, Request $request)
  {
    $match = ['product_id' => $request->product_id, 'showcase_id' => $showcase->id];

    $saved = ShowcaseProduct::where($match)->count();

    if($saved > 0)
    {
      ShowcaseProduct::where($match)->first()->delete();
    } else {
      ShowcaseProduct::create([
        'showcase_id' => $showcase->id,
        'product_id' => $request->product_id
      ]);
    }

    return response()->json(null, 200);
  }
}
