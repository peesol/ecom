<footer>
  <div class="col-3-flex-res padding-15-bottom panel medium">
    <div id="col-wrapper">
      <div class="content">
        <h2>Navigation</h2>
        <ul class="no-style link">
          <li><a href="#">Home</a></li>
          <li><a href="#">Shop</a></li>
          <li><a href="#">Contact us</a></li>
        </ul>
      </div>
    </div>
    <div id="col-wrapper">
      <div class="content">
        <h2>Social network</h2>
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
    </div>
    <div id="col-wrapper">
      <div class="content">
        <h2>Contact us</h2>
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
      </div>
    </div>
  </div>
  <div class="text-center">
    <p>Copyright ©2018 All rights reserved</p>
  </div>
</footer>
