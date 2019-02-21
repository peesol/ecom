@extends('app.layout')
@section('content')
<div class="panel-head large">
  <h1>Contact us</h1>
</div>
<div>
  <ul class="contact">
    @foreach ($contacts as $contact)
      @if ($contact->type == 'contact')
        <li class="{{ $contact->type . ' fas fa-' . $contact->sub }}">
          @if ($contact->link)
            <a href="{{$contact->link}}">{{$contact->body}}</a>
          @else
            <font>{{$contact->body}}</font>
          @endif
        </li>
      @endif
    @endforeach
  </ul>
  <h1>Follow us on social network</h1>
  <div class="grid-x">
    <div class="cell">
      <ul class="contact">
        @foreach ($contacts as $contact)
          @if ($contact->type == 'social')
            <li class="{{ $contact->type . ' fab fa-' . $contact->sub }}">
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

  </div>

</div>
@endsection
