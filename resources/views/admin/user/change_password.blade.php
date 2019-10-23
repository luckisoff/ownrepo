@extends('admin.layouts.app')

@section('title', 'Change password')

@section('content')

  <div class="row">
    <div class="col-md-offset-3 col-md-6">
      <form action="{{route('user.password.change.store')}}" method="post" id="asdh-change_password">
        {{csrf_field()}}
        <div class="card">

          <div class="card-header card-header-text" data-background-color="green">
            <h4 class="card-title">Change Password</h4>
          </div>

          <div class="card-content">

            {{--old password--}}
            <div class="form-group label-floating">
              <label class="control-label" for="old_password">
                Old Password
                <small>*</small>
              </label>
              <input type="password"
                     class="form-control"
                     id="old_password"
                     name="old_password"/>
            </div>

            {{--new password--}}
            <div class="form-group label-floating">
              <label class="control-label" for="new_password">
                New Password
                <small>*</small>
              </label>
              <input type="password"
                     class="form-control"
                     id="new_password"
                     name="new_password"/>
            </div>

            {{--new password confirmation--}}
            <div class="form-group label-floating">
              <label class="control-label" for="new_password_confirmation">
                Confirm New Password
                <small>*</small>
              </label>
              <input type="password"
                     class="form-control"
                     id="new_password_confirmation"
                     name="new_password_confirmation"/>
            </div>

            {{--submit--}}
            <div class="form-footer text-right">
              <button type="submit" class="btn btn-success btn-fill">Change</button>
            </div>

          </div>

        </div>
      </form>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      var $changePassword = $('#asdh-change_password');
      $changePassword.validate({
        rules   : {
          old_password             : {
            required : true,
            minlength: 6
          },
          new_password             : {
            required : true,
            minlength: 6
          },
          new_password_confirmation: {
            required : true,
            minlength: 6
          }
        },
        messages: {
          old_password             : {
            required : '*Old password is required',
            minlength: '*Password must be of minimum six characters long'
          },
          new_password             : {
            required : '*New password is required',
            minlength: '*Password must be of minimum six characters long'
          },
          new_password_confirmation: {
            required : '*New password confirmation field is required',
            minlength: '*Password must be of minimum six characters long'
          }
        }
      });
    });
  </script>
@endpush