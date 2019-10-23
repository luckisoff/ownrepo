@extends('admin.layouts.app')

@section('title', 'Home')

@section('content')

  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="orange">
          <i class="material-icons">person</i>
        </div>
        <div class="card-content">
          <p class="category">Users</p>
          <h3 class="card-title">{{ $total_users }}</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">date_range</i>
            From the beginning
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="rose">
          <i class="material-icons">adjust</i>
        </div>
        <div class="card-content">
          <p class="category">Questions</p>
          <h3 class="card-title">{{ \App\Question::count() }}</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">local_offer</i> From the beginning
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="green">
          <i class="material-icons">store</i>
        </div>
        <div class="card-content">
          <p class="category">Options</p>
          <h3 class="card-title">{{ \App\Option::count() }}</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">date_range</i> From the beginning
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="blue">
          {{--<i class="fa fa-twitter"></i>--}}
          <i class="material-icons">adjust</i>
        </div>
        <div class="card-content">
          <p class="category">Categories</p>
          <h3 class="card-title">{{ \App\Category::count() }}</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Total
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header card-header-text" data-background-color="green">
      <h4 class="card-title"><b>Notice</b></h4>
    </div>
    <div class="card-content">
      <form action="{{ route('notice-status.save') }}" id="notice-status-submit">
        {{--notice_status--}}
        <div class="form-group">
          <label for="">Status</label>
          <div class="radio">
            <label>
              <input type="radio" id="noticeOn" name="notice_status" value="1" required> On
            </label>

            <label>
              <input type="radio" id="noticeOff" name="notice_status" value="0" required> Off
            </label>
          </div>
        </div>
        {{--./notice_status--}}

        {{--notice_title--}}
        <div class="form-group {{ $errors->has('notice_title')?'has-error is-focused':'' }}">
          <label for="notice_title">{{ ucwords('title') }}</label>
          <input type="text"
                 class="form-control {{ $errors->has('notice_title')?'remove-error-message':'' }}"
                 id="notice_title"
                 name="notice_title"/>
        </div>
        {{--./title--}}

        {{--notice_message--}}
        <div class="form-group {{ $errors->has('notice_message')?'has-error is-focused':'' }}">
          <label for="notice_message">{{ ucwords('message') }}</label>
          <textarea name="notice_message"
                    id="notice_message"
                    rows="5"
                    class="form-control {{ $errors->has('notice_message')?'remove-error-message':'' }}"></textarea>
        </div>
        {{--./title--}}

        {{--submit--}}
        <div class="text-right">
          <button class="btn btn-success">Submit</button>
        </div>
        {{--./submit--}}
      </form>
    </div>
  </div>

 {{-- @foreach($weeklyWinners as $key=>$weeklyWinner)
    <div class="card">
      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title"><b>Week {{ $key }}</b> @if($loop->first) ( Current Week ) @endif</h4>
      </div>
      <div class="card-content">
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>Position</th>
              <th>Image</th>
              <th>Name</th>
              <th>Email</th>
              <th>Points</th>
              <th>Game Count</th>
            </tr>
            </thead>
            <tbody>
            @foreach($weeklyWinner as $data)
              <tr>
                <td>{{ $data['position'] }}</td>
                <td><img src="{{ $data['image'] }}" style="width:50px;height:50px;"></td>
                <td>{{ $data['name'] }}</td>
                <td>{{ $data['email'] }}</td>
                <td>{{ $data['point'] }} (<b>NRs. {{ $data['point']/100 }}</b>)</td>
                <td>{{ $data['count'] }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endforeach
--}}
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      let noticeStatus     = @json($settings);
      let $noticeStatusOn  = $('#noticeOn');
      let $noticeStatusOff = $('#noticeOff');
      let $noticeTitle     = $('#notice_title');
      let $noticeMessage   = $('#notice_message');

      if (noticeStatus.notice_status) {
        $noticeStatusOff.prop('checked', false);
        $noticeStatusOn.prop('checked', true);
      } else {
        $noticeStatusOn.prop('checked', false);
        $noticeStatusOff.prop('checked', true);
      }

      $noticeTitle.val(noticeStatus.notice_title);
      $noticeMessage.val(noticeStatus.notice_message);

      $('#notice-status-submit').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
          url    : '{{ route('notice-status.save') }}',
          data   : $(this).serialize(),
          success: function (response) {
            return showAlertMessageSuccess("Notice status changed successfully.");
          },
          error  : function (response) {
            console.log('Error: ', response);
          }
        });
      });
    });
  </script>
@endpush