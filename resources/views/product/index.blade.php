@extends('app.layout')
@section('content')
    <section class="grey">
      <div class="panel large">
        <h1>Featured products</h1>
      </div>
      <div class="panel large thumbnail-grid padding-15-v">
          <div class="thumbnail-wrapper product">
            <div class="thumbnail-img-wrapper">
              <a href="{{ route('productPage', ['product' => $product->uid]) }}">
                <img src="{{ $product->getThumbnail() }}" alt="img">
              </a>
            </div>
            <div class="details">
              <a class="title" href="{{ route('productPage', ['product' => $product->uid]) }}">{{ $product->name }}</a>
              <p class="price">{{ number_format($product->price) }}&nbsp;THB</p>
            </div>
          </div>
      </div>
    </section>
    <section>

    </section>
@endsection
