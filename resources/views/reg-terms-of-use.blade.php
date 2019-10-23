<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>KBC Nepal</title>
  <style>
    h1 {
      text-align : center;
    }

    .image-container {
      width  : 100px;
      margin : 0 auto;
    }

    .image-container img {
      width  : 100%;
      height : auto;
    }

    .text-center {
      text-align : center;
    }
  </style>
</head>
<body>
<div class="image-container">
  <img src="{{ frontend_url('assets/img/logo.png') }}" alt="KBC Nepal logo">
</div>
<h1>KBC Nepal</h1>

{{--<div class="text-center">
  <a href="{{ route('terms-of-use') }}">Terms of use</a>
  <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
</div>--}}

<div class="text-center">
  {!! $company->reg_terms_of_use !!}
</div>

</body>
</html>