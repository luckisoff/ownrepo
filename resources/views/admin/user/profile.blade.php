@extends('admin.layouts.app')

@section('title', $user->name . ' profile')

@section('content')

  <div class="card card-profile">
    <div class="card-avatar">
      <a href="#">
        <img class="img" src="{{$user->image(130,130)}}"/>
      </a>
    </div>
    <div class="card-content">
      {{--<h6 class="category text-gray">CEO / Co-Founder</h6>--}}
      <h4 class="card-title">{{ $user->name }}</h4>
      <p class="description">{{ $user->email }}, {{ $user->phone }}</p>
      <p class="description">{{ $user->address }}</p>
      <div class="description text-left">
        {!! $user->about !!}
      </div>
      {{--<a href="#" class="btn btn-rose btn-round">Follow</a>--}}
    </div>
  </div>

@endsection
