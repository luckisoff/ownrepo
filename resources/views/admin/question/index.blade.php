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
    @if(request()->is('admin/question-set*'))
      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">All questions of question set <b>{{ $question_set->title }}</b></h4>
      </div>
      <a href="{{ route($routeType.'.create',['question_set_id' => $question_set->id]) }}" class="btn btn-success btn-round btn-xs create-new">
        <i class="material-icons">add_circle_outline</i> New Question
      </a>
    @elseif(request()->is('admin/setquestion*'))
      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">All questions of question set <b>{{ $setquestion->name }}</b></h4>
      </div>
      <a href="{{ route($routeType.'.create') }}" class="btn btn-success btn-round btn-xs create-new">
        <i class="material-icons">add_circle_outline</i> New Question
      </a>
    @else
      @include('extras.index_header')
    @endif

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            <th>Question</th>
            @if(!request()->is('admin/question-set*') && !request()->is('admin/setquestion*'))
              <th>Q. No.</th>
              <th>Category</th>
            @endif
            <th width="80">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{ request()->has('page')?((request()->page-1)*30 + $key+1):($key+1) }}</td>
              <td>{{ $model->name }}</td>
              @if(!request()->is('admin/question-set*') && !request()->is('admin/setquestion*'))
                <td>{{ optional($model->difficulty_level)->level }}</td>
                <td>{{ optional($model->category)->name }}</td>
              @endif
              <td class="asdh-edit_and_delete td-actions">
                @if(request()->is('admin/question-set*'))
                  <a href="{{ route($routeType.'.edit', [$model, 'question_set_id' => $question_set->id]) }}"
                     type="button"
                     class="btn btn-success"
                     title="Edit">
                    <i class="material-icons">edit</i>
                  </a>
                @endif

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
            'targets'  : [4]
          }]
        });
      });
    </script>
  @endpush
@endif