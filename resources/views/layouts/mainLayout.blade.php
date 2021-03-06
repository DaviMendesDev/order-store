<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> @yield('title') </title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  @yield('extra-styles')
</head>
<body class="bg-orange-50/50">
  <div id="app">
    @yield('content')
  </div>
  <script src="{{ mix('/js/app.js') }}"></script>

  @yield('extra-scripts')
</body>
</html>
