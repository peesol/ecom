<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Fonts -->

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
    window.Data = {
      url: '{{ config('app.url') }}',
      locale: '{{ App::getLocale() }}',
      csrf: '{{ csrf_token() }}',
      user: {
        authenticated: {{ Auth::check() ? 'true' : 'false' }},
        role: 'guest',
      }
    };
    </script>
  </head>
  <body>
    <div id="app">
      @include('app._navigation')
      <vue-progress-bar></vue-progress-bar>
      <load-overlay :show="$root.loading"></load-overlay>
      <div class="grid-container container">
        @yield('content')
      </div>
      @include('app._footer')
      @if (Auth::id() === 1)
        <button class="admin-btn fas fa-home" onclick="window.location.href='{{ route('adminIndex') }}'">&nbsp;หลังร้าน</button>
      @endif
    </div>
  </body>
</html>
