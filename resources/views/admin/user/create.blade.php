@extends('admin.layouts.app')

@section('title', 'Add a New User')

@section('content')

  <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data" id="TypeValidation" class="from-prevent-multiple-submit">
    {{csrf_field()}}
    <div class="card">
      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">Add a New User</h4>
      </div>

      <div class="card-content">

        <div class="row">
          <div class="col-md-2">
            {{--image--}}
            @include('extras.input_image')

            <hr>
            {{--roles--}}
            <div class="form-group">
              <label for="roles">Assign roles</label>
              @foreach($roles as $role)
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="role[]" value="{{$role->id}}"> {{$role->name()}}
                  </label>
                </div>
              @endforeach
            </div>
            <hr>
          </div>
          <div class="col-md-10">
            <div class="row">
              {{--name--}}
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label" for="name">
                    Name
                    <small>*</small>
                  </label>
                  <input type="text"
                         class="form-control"
                         id="name"
                         name="name"
                         required="true"
                         value="{{old('name')}}"/>
                </div>
              </div>
              {{--email--}}
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label" for="email">
                    Email
                    <small>*</small>
                  </label>
                  <input type="email"
                         class="form-control"
                         id="email"
                         name="email"
                         required="true"
                         email="true"
                         value="{{old('email')}}"/>
                </div>
              </div>
            </div>

            <div class="row">
              {{--password--}}
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label" for="password">
                    Password
                    <small>*</small>
                  </label>
                  <input type="password"
                         class="form-control"
                         id="password"
                         name="password"
                         required="true"
                         value="{{old('password')}}"/>
                </div>
              </div>
              {{--password confirmation--}}
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label" for="password_confirmation">
                    Confirm Password
                    <small>*</small>
                  </label>
                  <input type="password"
                         class="form-control"
                         id="password_confirmation"
                         name="password_confirmation"
                         required="true"
                         value="{{old('password_confirmation')}}"/>
                </div>
              </div>
            </div>

            <div class="row">
              {{--address--}}
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label" for="address">
                    Address
                  </label>
                  <input type="text"
                         class="form-control"
                         id="address"
                         name="address"
                         value="{{old('address')}}"/>
                </div>
              </div>
              {{--phone--}}
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label class="control-label" for="phone">
                    Phone
                  </label>
                  <input type="text"
                         class="form-control"
                         id="phone"
                         name="phone"
                         number="true"
                         value="{{old('phone')}}"/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                {{--facebook_url--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="facebook_url">Facebook Url</label>
                  <input type="url"
                         class="form-control"
                         id="facebook_url"
                         name="facebook_url"
                         url="true"
                         value="{{old('facebook_url')}}"/>
                </div>
                {{--./facebook_url--}}
              </div>
              <div class="col-md-6">
                {{--twitter_url--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="twitter_url">Twitter Url</label>
                  <input type="url"
                         class="form-control"
                         id="twitter_url"
                         name="twitter_url"
                         url="true"
                         value="{{old('twitter_url')}}"/>
                </div>
                {{--./twitter_url--}}
              </div>
            </div>

            {{--about--}}
            <div class="form-group">
              <label class="control-label" for="about">About</label>
              <textarea class="form-control asdh-tinymce" id="about" name="about" rows="10">{{old('about')}}</textarea>
            </div>

          </div>
        </div>

        {{--submit--}}
        <div class="form-footer text-right">
          <button type="submit" class="btn btn-success btn-fill btn-prevent-multiple-submit">Add</button>
        </div>

      </div>
    </div>
  </form>
@endsection

@push('script')
  @include('extras.tinymce')
  <script>
    $(document).ready(function () {
      $('#name').focus();
    });
  </script>
@endpush