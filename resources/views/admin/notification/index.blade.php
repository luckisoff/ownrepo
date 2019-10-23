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
    @include('extras.index_header')

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="40">#</th>
            <th>Title</th>
            <th>Body</th>
            <th>Sent</th>
            <th width="80">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$model->title}}</td>
              <td>{{$model->body}}</td>
              <td>{{$model->created_at}}</td>
              <td class="asdh-edit_and_delete td-actions">
                @include('extras.edit_delete', ['modal'=>$model, 'message'=>'You will not be able to recover your data in the future.'])
                <a href="{{ route($routeType.'.edit', $model) }}" type="button" class="btn btn-success" title="Send again">
                  <i class="material-icons">send</i>
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
