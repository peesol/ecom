<nav>
  <div class="panel large nav-wrapper">
    <div class="logo-wrapper">
      <img src="{{ asset('/file/logo/logo.jpg') }}" alt="">
    </div>
    <div class="links-wrapper">
      <a href="{{ route('home') }}">HOME</a>
      <a href="{{ route('shop') }}">SHOP</a>
      <a href="{{ route('home') }}">FAQ*</a>
      <a href="{{ route('contact') }}">CONTACT US</a>
    </div>
    <div class="menu">
      <button class="fas fa-bars" type="button" name="button"></button>
    </div>
    <cart-icon></cart-icon>
  </div>
</nav>
