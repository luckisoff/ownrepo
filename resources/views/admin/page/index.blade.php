@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@section('content')

  <div class="card">
    @include('extras.index_header')

    <div class="card-content">

      {{--all models--}}
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            <th>Image</th>
            <th>Title</th>
            <th>Slug</th>
            <th width="80">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr id="asdh-{{$model->id}}"
                class="asdh-all {{$model->home?'asdh-in-home':'asdh-not-in-home'}} {{$model->active?'asdh-active':'asdh-inactive'}}">
              <td>{{$key+1}}</td>
              <td width="60"><img src="{{$model->image(50,50)}}" alt="{{$model->name}}"></td>
              <td>{{$model->title}}</td>
              <td>{{$model->slug}}</td>
              <td class="asdh-edit_and_delete td-actions">
                @include('extras.edit_delete', ['modal'=>$model, 'message'=>'You will not be able to recover your data in the future.'])
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
      {{--./all models--}}

    </div>
  </div>

@endsection

@if($models->count())
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
            'targets': [1, 4]
          }]
        });
      });
    </script>
  @endpush
@endif
