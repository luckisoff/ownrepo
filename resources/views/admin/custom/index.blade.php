@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@section('content')

  <div class="card">
    @include('extras.index_header', ['custom_name' => 'posts'])

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
            <th width="50">Home</th>
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
              <td class="text-center" style="position:relative;">
                <div class="checkbox" style="position:absolute;top:0;">
                  <label data-id="{{ $model->id }}" data-url="{{ route('ajax.custom.home') }}">
                    <input type="checkbox" name="active" class="custom-home" {{ $model->home?'checked':'' }}>
                  </label>
                </div>
              </td>
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
            'targets': [1, 4, 5]
          }]
        });

        $('.custom-home').change(function () {
          customAjaxRequest($(this));
        });
      });

      function customAjaxRequest($object) {
        var parentLabel = $object.parent('label');
        $.ajax({
          'url': parentLabel.data('url'),
          'data': {'id': parentLabel.data('id')},
          'success': function (data) {
            alert(data.message);
          },
          'error': function (data) {
            console.log(data);
          }
        });
      }
    </script>
  @endpush
@endif
