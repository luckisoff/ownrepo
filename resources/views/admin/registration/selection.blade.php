@extends('admin.layouts.app')

@section('title', 'Select user randomly')

@push('css')
  <style>
    @keyframes lds-ripple {
      0% {
        top     : 96px;
        left    : 96px;
        width   : 0;
        height  : 0;
        opacity : 1;
      }
      100% {
        top     : 18px;
        left    : 18px;
        width   : 156px;
        height  : 156px;
        opacity : 0;
      }
    }

    @-webkit-keyframes lds-ripple {
      0% {
        top     : 96px;
        left    : 96px;
        width   : 0;
        height  : 0;
        opacity : 1;
      }
      100% {
        top     : 18px;
        left    : 18px;
        width   : 156px;
        height  : 156px;
        opacity : 0;
      }
    }

    .lds-ripple {
      position : relative;
    }

    .lds-ripple div {
      box-sizing        : content-box;
      position          : absolute;
      border-width      : 4px;
      border-style      : solid;
      opacity           : 1;
      border-radius     : 50%;
      -webkit-animation : lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
      animation         : lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    .lds-ripple div:nth-child(1) {
      border-color : #1d3f72;
    }

    .lds-ripple div:nth-child(2) {
      border-color            : #5699d2;
      -webkit-animation-delay : -0.5s;
      animation-delay         : -0.5s;
    }

    .lds-ripple {
      width             : 200px !important;
      height            : 200px !important;
      -webkit-transform : translate(-100px, -100px) scale(1) translate(100px, 100px);
      transform         : translate(-100px, -100px) scale(1) translate(100px, 100px);
    }
  </style>
@endpush

@section('content')
  <div class="card">
    <div class="card-header card-header-text" data-background-color="green">
      <h4 class="card-title">Select user randomly from <b>Online Registration</b></h4>
    </div>

    <div class="card-content">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          @if(!request()->has('selected'))
            {{--@if(false)--}}
            {{--loading effect--}}
            <div class="lds-css ng-scope" style="display: none;">
              <div style="width:100%;height:100%;margin:0 auto;" class="lds-ripple">
                <div></div>
                <div></div>
              </div>
            </div>
            {{--./loading effect--}}

            <button class="btn btn-warning btn-block get-a-random-user">Randomly Select User</button>
          @else
            <div class="text-center">
              <h3 style="font-weight: bold;">The selected user is:</h3>
              <img src="{{ asset('public/images/no-image.jpg') }}" alt="" style="width:200px">
              <p>{{ $selectedUser->name }}</p>
              <p>{{ $selectedUser->email }}</p>
              <p>{{ $selectedUser->age }}</p>
              <p>{{ $selectedUser->gender }}</p>

              <a href="{{ route('registration.selection') }}" class="btn btn-warning">
                <i class="material-icons">keyboard_backspace</i> Go Back
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  @if($selectedUsers->count())
    <h4>Selected Participants</h4>
    <div class="card" style="margin-top: 0;">
      <div class="card-content">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>S.N.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Age</th>
          </tr>
          </thead>
          <tbody>
          @foreach($selectedUsers as $key=>$selectedUser)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $selectedUser->name }}</td>
              <td>{{ $selectedUser->email }}</td>
              <td>{{ $selectedUser->gender }}</td>
              <td>{{ $selectedUser->age }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endif
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      $('.get-a-random-user').on('click', function (event) {
        $('.lds-css').show();
        event.preventDefault();
        setTimeout(function () {
          location.href = '{{ route('registration.selection',['selected']) }}'
        }, 3000)
      })
    })
  </script>
@endpush