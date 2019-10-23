@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@push('css')
  @if(request()->is('admin/question-set/*'))
    <style>
      .asdh-edit {
        display : none;
      }
    </style>
  @endif
@endpush

@section('content')

  <div class="card">
    <div class="card-header card-header-text" data-background-color="green">
      <h4 class="card-title">All <b>Questions</b></h4>
    </div>

    <a href="{{ route($routeType.'.create') }}" class="btn btn-success btn-round btn-xs create-new">
      <i class="material-icons">add_circle_outline</i> New Question
    </a>


    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            <th>Question</th>
            <th width="80">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{ request()->has('page')?((request()->page-1)*30 + $key+1):($key+1) }}</td>
              <td>{{ $model->question }}</td>
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
    </div>

    <div class="card-footer text-center">
      {{ $models->links() }}
    </div>


  </div>
@endsection

@if($models->count())
  @push('script')
    <script>
      $(document).ready(function () {
        $('table').dataTable({
          "paging"      : false,
          "lengthChange": true,
          "lengthMenu"  : [30, 50, 100],
          "searching"   : true,
          "ordering"    : true,
          "info"        : false,
          "autoWidth"   : false,
          'columnDefs'  : [{
            'orderable': false,
            'targets'  : [2]
          }]
        });
      });
    </script>
  @endpush
@endif