@extends('app.layout')
@section('content')
  <banner-slick :banners="{{ $banners }}" :enable-dots="false"></banner-slick>
  @if ($products)
    <section>
      <div class="panel large">
        <h1>Featured products</h1>
      </div>
      <div class="panel large padding-15-v">
        <product-slick :products="{{ $products }}"></product-slick>
      </div>
    </section>
  @endif
    <section>
      <div class="grid-x medium-up-2">
        <div class="cell">
          <h1 class="main-color">Finest quality</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
        </div>
        <div class="cell text-center align-self-middle">
          <h3>Get 50% off</h3>
          <button class="btn btn margin-15-v" name="button">Shop now</button>
        </div>
      </div>
    </section>
    @if ($promotion)
      <section>
        <div class="panel large">
          <h1>Promotions</h1>
        </div>
        <div class="panel large padding-15-v">
          <product-slick :products="{{$promotion}}"></product-slick>
        </div>
      </section>
    @endif
    @if ($showcases)
      <section>
        @foreach ($showcases as $showcase)
          @if (count($showcase->products))
            <h3>{{ $showcase->name }}</h3>
            <div class="panel large padding-15-v">
              <product-slick :products="{{$showcase->products}}"></product-slick>
            </div>
          @endif
        @endforeach
      </section>
    @endif
@endsection
