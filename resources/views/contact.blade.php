@extends('app.layout')
@section('content')
<div class="panel-head large">
  <h1>ติดต่อเรา</h1>
</div>
<div class="panel large padding-10-h-mobile">
  <ul class="no-style contact">
    @foreach ($contacts as $contact)
      @if ($contact->type == 'contact')
        <li class="{{ $contact->type . ' ' . $contact->sub }}">
          @if ($contact->link)
            <a href="{{$contact->link}}">{{$contact->body}}</a>
          @else
            <font>{{$contact->body}}</font>
          @endif
        </li>
      @endif
    @endforeach
  </ul>
  <h1>โซเชียล</h1>
  <ul class="no-style contact">
    @foreach ($contacts as $contact)
      @if ($contact->type == 'social')
        <li class="{{ $contact->type . ' ' . $contact->sub }}">
          @if ($contact->link)
            <a href="{{$contact->link}}">{{$contact->body}}</a>
          @else
            <font>{{$contact->body}}</font>
          @endif
        </li>
      @endif
    @endforeach
  </ul>
</div>
@endsection
