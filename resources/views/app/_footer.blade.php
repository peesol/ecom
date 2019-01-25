<footer>
  <div class="grid-container">
    <div class="grid-x grid-padding-x grid-padding-y medium-up-3">
      <div class="cell">
        <h2>Navigation</h2>
        <ul class="no-style link">
          <li><a href="#">Home</a></li>
          <li><a href="#">Shop</a></li>
          <li><a href="#">Contact us</a></li>
        </ul>
      </div>
      <div class="cell">
        <h2>Social network</h2>
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
      <div class="cell">
        <h2>Contact us</h2>
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
      </div>
    </div>
    <div class="text-center small-12 medium-12 cell">
      <p class="no-margin padding-15-v">Copyright ©2018 All rights reserved</p>
    </div>
  </div>
</footer>
