<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
  public function index()
  {
    return view('admin.contact.index');
  }

  public function create(Request $request)
  {
    $created = Contact::create([
      'type' => $request->type,
      'sub' => $request->sub,
      'body' => $request->body,
      'link' => $request->link
    ]);

    return response()->json($created);
  }

  public function update(Request $request)
  {
    Contact::find($request->id)->update([
      'type' => $request->type,
      'sub' => $request->sub,
      'body' => $request->body,
      'link' => $request->link
    ]);
    return ;
  }

  public function delete(Request $request, Contact $contact)
  {
    $contact->delete();
    return;
  }
}
