<?php

namespace App\Http\Controllers\Admin\Showcase;

use App\Models\Showcase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowcaseController extends Controller
{
  public function create(Request $request)
  {

    $showcase = Showcase::create([
      'name' => $request->name,
      'order' => $request->order,
      'show' => true
    ]);

    return response()->json($showcase);
  }

  public function delete(Showcase $showcase)
  {
    $showcase->delete();

    return;
  }

  public function showToggle(Showcase $showcase)
  {
    if($showcase->show == true)
    {
      $showcase->update([ 'show' => false ]);
    } else {
      $showcase->update([ 'show' => true ]);
    }

    return ;
  }

  public function updateOrder(Request $request)
  {
    foreach ($request->showcases as $index => $showcase) {
      Showcase::find($showcase['id'])->update(['order' => $index]);
    }

    return response()->json();
  }
}
