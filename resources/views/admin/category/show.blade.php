@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@push('css')
  @if(request()->is('admin/question-set/*') || request()->is('admin/sponsor*'))
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
    @elseif(request()->is('admin/sponsor*'))
      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">All questions of sponsor <b>{{ $sponsor->name }}</b></h4>
      </div>
      <a href="{{ route('question.create', ['sponsor_id'=>$sponsor->id]) }}" class="btn btn-success btn-round btn-xs create-new">
        <i class="material-icons">add_circle_outline</i> Add Question
      </a>
    @else
      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">All questions of
          <b>{{ optional(optional($models->first())->category)->name }}</b> category</h4>
      </div>
    @endif

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            <th>Question</th>
            @if(!request()->is('admin/question-set*') && !request()->is('admin/sponsor*'))
              <th width="80">Q. No.</th>
            @endif
            <th width="80" class="text-center">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{ request()->has('page')?((request()->page-1)*30 + $key+1):($key+1) }}</td>
              <td>
                {{ $model->name }} <br>
                <b>Ans:</b> {{ $model->options()->where('answer', 1)->first()->name }}
              </td>
              @if(!request()->is('admin/question-set*') && !request()->is('admin/sponsor*'))
                <td>{{ optional($model->difficulty_level)->level }}</td>
              @endif
              <td class="asdh-edit_and_delete td-actions">
                @if(request()->is('admin/question-set*'))
                  <a href="{{ route($routeType.'.edit', [$model, 'question_set_id' => $question_set->id]) }}"
                     type="button"
                     class="btn btn-success"
                     title="Edit">
                    <i class="material-icons">edit</i>
                  </a>
                @elseif(request()->is('admin/sponsor*'))
                  <a href="{{ route($routeType.'.edit', [$model, 'sponsor_id' => $sponsor->id]) }}"
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