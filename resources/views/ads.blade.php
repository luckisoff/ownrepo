<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Advertisement - {{ $ad->title }}</title>
</head>
<body>
<section>
  <h1>{{ $ad->title }}</h1>

  <img src="{{ $ad->image }}" alt="{{ $ad->title }}" style="width:200px;">

  <p>Contact Number: {{ $ad->contact }}</p>
  <p>Email: {{ $ad->email }}</p>

  <div>
    {!! $ad->description !!}
  </div>
</section>
</body>
</html>