@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@push('css')
  <style>
    .asdh-edit {
      display : none;
    }
  </style>
@endpush

@section('content')

  <div class="card">
    <div class="card-header card-header-text" data-background-color="green">
      <h4 class="card-title">All <b>{{ str_plural(getNewsFeedName()) }}</b></h4>
    </div>
    <a href="{{ route($routeType.'.create',['type'=>request()->query('type')]) }}"
       class="btn btn-success btn-round btn-xs create-new">
      <i class="material-icons">add_circle_outline</i> New {{ getNewsFeedName() }}
    </a>

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            @if(!(request()->query('type') == 'video'))
              <th>Image</th>
            @endif
            <th>Title</th>
            <th width="80">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{ $key+1 }}</td>
              @if(!(request()->query('type') == 'video'))
                <td width="60"><img src="{{ optional($model->images->first())->image(50,50) }}"
                                    alt="{{ $model->title }}"></td>
              @endif
              <td>{{ $model->title }}</td>
              <td class="asdh-edit_and_delete td-actions">
                <a href="{{ route($routeType.'.edit', [$model, 'type'=>request()->query('type')]) }}"
                   type="button"
                   class="btn btn-success"
                   title="Edit">
                  <i class="material-icons">edit</i>
                </a>
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
            'targets'  : [1,3]
          }]
        });
      });
    </script>
  @endpush
@endif