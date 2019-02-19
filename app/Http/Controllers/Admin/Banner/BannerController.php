<?php

namespace App\Http\Controllers\Admin\Banner;

use Storage;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
  public function index()
  {
    $banners = Banner::all();

    return view('admin.banner.index', ['banners' => $banners]);
  }

  public function create(Request $request)
  {
    $banner = $request->image;

    $fileName = uniqid('banner_');

    $exploded = explode(',', $banner);

    $img = base64_decode($exploded[1]);

    Storage::disk('public')->put('/banner/home/' . $fileName . '.jpg', $img);

    Banner::create([
      'filename' => $fileName . '.jpg',
      'text' => $request->text,
      'button' => $request->button,
      'link' => $request->link
    ]);

    return;
  }

  public function delete(Banner $banner)
  {
    Storage::disk('public')->delete('/banner/home/' . $banner->filename);
    $banner->delete();
    return;
  }
}
