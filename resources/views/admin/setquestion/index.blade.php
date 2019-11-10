@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@section('content')

  <div class="card">
    @include('extras.index_header',['custom_name'=>'Question Set'])

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            {{-- <th width="150">Background Image</th> --}}
            <th>Set Name</th>
            <th>Reward Price</th>
            <th>Type</th>
            {{-- <th>Set Status</th> --}}
            <th width="140" class="text-center">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{$key+1}}</td>
              <td><a href="{{ route('setquestion.show', $model->id) }}">{{$model->name}} ({{ $model->question_count }})</a>
                @if($model->question_count<=10)
                  <span style="color:red">*****</span>
                @elseif($model->question_count<15)
                  <span style="color:red">***</span>
                @endif
              </td>
              <td>{{$model->price}}</td>
              <td>{{$model->questionType['name']}}</td>
              {{-- <td>{!!$model->status==1?"<span class='label label-success'>Active</span>":"<span class='label label-danger'>Deactive</span>"!!}</td>
               --}}
              <td class="asdh-edit_and_delete td-actions">
                <a href="{{ route('setquestion.show', $model) }}"
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
        $('.table').dataTable({
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