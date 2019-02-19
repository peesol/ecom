<?php

namespace App\Http\Controllers\Admin\Config;

use Image;
use Storage;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
  public function getConfig()
  {
    return response()->json(Config::all());
  }

  public function updateLogo(Request $request)
  {
    if (Config::where('type', 'logo')->count()) {
      Storage::disk('public')->delete('/logo/' . 'logo.jpg');
    } else {
      Config::create([
        'type' => 'logo',
        'value' => 'logo.jpg'
      ]);
    }

    $exploded = explode(',', $request->logo);

    $img = base64_decode($exploded[1]);

    Storage::disk('public')->put('/logo/' . 'logo.jpg', $img);

    return ;
  }

  public function updateDesc(Request $request)
  {
    
    Config::where('type', 'description')->update([
      'array_value' => $request->description
    ]);

    return;
  }

}
