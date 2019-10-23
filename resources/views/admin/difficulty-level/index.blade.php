@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@section('content')

  <div class="card">
    @include('extras.index_header', ['custom_name' => 'Difficulty Level'])

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th>Sponser</th>
            <th>Level</th>
            <th>Price</th>
            <th>Point</th>
            <th width="80">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($models as $key=>$model)
            <tr>
              <td width="50">
                 <!--<img src="{{ $model->sponser_image?$model->image(65,65,'sponser_image'):asset('images/no-image.jpg') }}" alt="Level {{ $model->level }}"> -->
                </td>
              <td>{{ $model->level }}</td>
              <td>{{ $model->price }}</td>
              <td>{{ $model->point }}</td>
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
  </div>
@endsection

@if($models->count())
  @push('script')
    <script>
      $(document).ready(function () {
        /*$('table').dataTable({
          "paging"      : false,
          "lengthChange": true,
          "lengthMenu"  : [10, 15, 20],
          "searching"   : true,
          "ordering"    : true,
          "info"        : false,
          "autoWidth"   : false,
          'columnDefs'  : [{
            'orderable': false,
            'targets'  : [3]
          }]
        });*/
      });
    </script>
  @endpush
@endif