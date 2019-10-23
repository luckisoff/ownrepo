<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  @include('admin.layouts.header')
</head>

<body>

<div class="wrapper">
  @include('admin.layouts.leftSidebar')
  <div class="main-panel">
    @include('admin.layouts.navbar')
    <div class="content">
      <div class="container-fluid">
        @include('extras.backend_message')
        @include('extras.alert_message')
        @yield('content')
      </div>
    </div>
    <footer class="footer">
      <div class="container-fluid">
        <p class="copyright pull-right">
          &copy;
          <a href="{{ route('home') }}">{{$company->name}}</a>,
          <script>
            document.write(new Date().getFullYear())
          </script>
        </p>
      </div>
    </footer>
  </div>
</div>

</body>

@include('admin.layouts.footer')
</html>