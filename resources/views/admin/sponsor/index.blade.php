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
            <th>Background</th>
            <th>Ad</th>
            <th>Name</th>
            <th width="120" class="text-center">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{$key+1}}</td>
              <td width="90">
                <img src="{{$model->image(50,50)}}"
                     style="border-radius:50%;width:50px;height:50px;">
              </td>
              <td width="120">
                <img src="{{$model->image(50,50, 'background_image')}}"
                     style="border-radius:50%;width:50px;height:50px;">
              </td>
              <td width="90">
                <img src="{{$model->image(50,50, 'ad_image')}}"
                     style="border-radius:50%;width:50px;height:50px;">
              </td>
              <td>
                <a href="{{ route('sponsor.show', $model) }}">
                  {{$model->name}} ({{ $model->questions_count }} {{ str_plural('question', $model->questions_count) }})
                </a>
              </td>
              <td class="asdh-edit_and_delete td-actions">
                <a href="{{ route('question.create', ['sponsor_id'=>$model->id]) }}"
                   type="button"
                   class="btn btn-warning asdh-add-questions"
                   title="Add questions">
                  <i class="material-icons">add</i>
                </a>
                <a href="{{ route('sponsor.show', ['sponsor_id'=>$model->id]) }}"
                   type="button"
                   class="btn btn-info asdh-add-questions"
                   title="View Questions">
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
          "paging"      : true,
          "lengthChange": true,
          "lengthMenu"  : [20, 50, 100],
          "searching"   : true,
          "ordering"    : true,
          "info"        : false,
          "autoWidth"   : false,
          'columnDefs'  : [{
            'orderable': false,
            'targets'  : [1, 2, 3, 5]
          }]
        });
      });
    </script>
  @endpush
@endif