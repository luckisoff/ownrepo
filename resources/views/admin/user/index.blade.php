@extends('admin.layouts.app')

@section('title', 'All Users')

@section('content')

  <div class="card">
    @include('extras.index_header')

    <div class="card-content">
      <ul class="nav nav-pills nav-pills-warning">
        @foreach($roles as $key=>$role)
          <li @if($key==0) class="active" @endif>
            <a href="#{{$role->name_camel_case()}}" data-toggle="tab">{{$role->name()}} ({{$role->users->count()}})</a>
          </li>
        @endforeach
      </ul>

      <div class="tab-content">
        @foreach($roles as $key=>$role)
          <div class="tab-pane @if($key==0) active @endif" id="{{$role->name_camel_case()}}">
            <div class="table-responsive">
              <table class="table role-{{str_slug($role->name)}}">
                <thead>
                <tr>
                  <th width="40">#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Verified</th>
                  <th width="80">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($role->users as $key=>$user)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td width="60"><img src="{{$user->image(50,50)}}" alt="{{$user->name}}"></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->verified()}}</td>
                    <td class="asdh-edit_and_delete td-actions">
                      @include('extras.edit_delete', ['modal'=>$user, 'message'=>'You will not be able to recover your data in the future.'])
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      $('table').dataTable({
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [10, 15, 20],
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        'columnDefs': [{
          'orderable': false,
          'targets': [4]
        }]
      });
    });
  </script>
@endpush
