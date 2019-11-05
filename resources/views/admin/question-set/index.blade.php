@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@section('content')

  <div class="card">
    @include('extras.index_header',['custom_name'=>'Live Quiz'])

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            {{-- <th width="150">Background Image</th> --}}
            <th>Title</th>
            <th>Timer</th>
            <th>Start time</th>
            <th>Sponsor</th>
            <th>End time</th>
            <th width="140" class="text-center">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{$key+1}}</td>
              {{-- <td><img src="{{$model->image(50,50,'sponser_image')}}" alt="{{$model->title}}" style="width:50px;height:50px;border-radius:50%;"></td>
               --}}
              <td><a href="{{ route('question-set.show', $model->id) }}">{{$model->title}} ({{ $model->questions_count }})</a></td>
              <td>{{$model->counter}}</td>
              <td>{{$model->start_time->format('M d Y, h:i A')}}</td>
              <td>{{$model->sponsor->name}}</td>
              <td>{{$model->end_time->format('M d Y, h:i A')}}</td>
              <td class="asdh-edit_and_delete td-actions">
                <a href="{{ route('question.create',['question-set-id' => $model->id]) }}"
                   type="button"
                   class="btn btn-warning"
                   title="Add question">
                  <i class="material-icons">add</i>
                </a>
                <a href="{{ route('question-set.show', $model) }}"
                   type="button"
                   class="btn btn-info"
                   title="See all questions of this set">
                  <i class="material-icons">remove_red_eye</i>
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
          "paging"      : false,
          "lengthChange": true,
          "lengthMenu"  : [10, 15, 20],
          "searching"   : true,
          "ordering"    : true,
          "info"        : false,
          "autoWidth"   : false,
          'columnDefs'  : [{
            'orderable': false,
            'targets'  : [1,5]
          }]
        });
      });
    </script>
  @endpush
@endif