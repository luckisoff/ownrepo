@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@section('content')

  <div class="card">
    <div class="card-header card-header-text" data-background-color="green">
      <h4 class="card-title">All {{str_plural(ucwords($routeType))}}</h4>
      {{--<p class="category">New employees on 15th September, 2016</p>--}}
    </div>

    <div class="card-content">
      <div class="table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th width="60">#</th>
            <th>Email</th>
          </tr>
          </thead>
          <tbody>
          @forelse($subscribers as $key=>$subscriber)
            <tr id="asdh-{{$subscriber->id}}">
              <td>{{$key+1}}</td>
              <td>{{$subscriber->email}}</td>
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

@if($subscribers->count())
  @push('script')
    <script>
      $(document).ready(function () {
        $('table').dataTable({
          "paging": true,
          "lengthChange": true,
          "lengthMenu": [10, 15, 20, 50, 100],
          "searching": true,
          "ordering": true,
          "info": false,
          "autoWidth": false,
          'columnDefs': [{
            'orderable': false
          }]
        });
      });
    </script>
  @endpush
@endif