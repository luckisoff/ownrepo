@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@section('content')

  <div class="card">
    @include('extras.index_header')

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            <th>Image</th>
            <th>Title</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Video Link</th>
            <th>Visits</th>
            <th width="120">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{$key+1}}</td>
              <td width="50">
                @if($model->image)
                  <img src="{{$model->image}}" alt="{{$model->title}}">
                @endif
              </td>
              <td>{{$model->title}}</td>
              <td><a href="tel:{{$model->contact}}">{{$model->contact}}</a></td>
              <td><a href="mailto:{{$model->email}}">{{$model->email}}</a></td>
              <td>{{$model->video_link}}</td>
              <td>{{$model->visits}}</td>
              <td class="asdh-edit_and_delete td-actions">
                @include('extras.edit_delete', ['modal'=>$model, 'message'=>'You will not be able to recover your data in the future.'])
                <a href="{{ route('ad', $model->slug) }}" type="button" class="btn btn-warning" title="Visit site" target="_blank">
                  <i class="material-icons">link</i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4">No data available</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@if($models->count())
  @push('script')
    <script>
      $(document).ready(function () {
        $('table').dataTable({
          "paging"      : true,
          "lengthChange": true,
          "lengthMenu"  : [10, 15, 20],
          "searching"   : true,
          "ordering"    : true,
          "info"        : false,
          "autoWidth"   : false,
          'columnDefs'  : [{
            'orderable': false,
            'targets'  : [1, 6]
          }]
        });
      });
    </script>
  @endpush
@endif