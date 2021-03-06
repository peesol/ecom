<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Fonts -->

    <!-- Styles -->
    <style media="all">
      footer {
        color: #fff;
        text-align: center;
        padding: 10px 0
      }
      body {
        background: #ddd !important
      }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
    {{-- JS --}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
    window.Data = {
      url: '{{ config('app.url') }}',
      locale: '{{ App::getLocale() }}',
      user: {
        authenticated: {{ Auth::check() ? 'true' : 'false' }},
        role: 'admin',
      }
    };
    </script>

  </head>
  <body>
    <div id="app">
      <vue-progress-bar></vue-progress-bar>

        @yield('content')

    </div>
    <footer>Management system by Dolphin</footer>
  </body>
</html>
