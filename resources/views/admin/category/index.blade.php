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
            <th>Name</th>
            <th>Color</th>
            <th>Slug</th>
            <th width="80">Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($categories as $key=>$category)
            <tr>
              <td>{{$key+1}}</td>
              <td width="60"><img src="{{$category->image(50,50)}}" alt="{{$category->name}}"></td>
              <td>
                <a href="{{ route('category.show', $category) }}"
                   title="See all questions of this category">{{$category->name}} ({{$category->questions_count}} questions)</a>
              </td>
              <td style="background:{{ $category->color }};">{{$category->color}}</td>
              <td>{{$category->slug}}</td>
              <td class="asdh-edit_and_delete td-actions">
                @include('extras.edit_delete', ['modal'=>$category, 'message'=>'All the data related to this category will be assigned to Uncategorized category.'])
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

    <div class="card-footer" style="display: none;">
      <a href="#" class="btn btn-danger multiple-delete-button">Delete</a>
    </div>

  </div>
@endsection

@if($categories->count())
  @push('script')
    <script>
      $(document).ready(function () {
        /*$('table').dataTable({
          "paging": true,
          "lengthChange": true,
          "lengthMenu": [10, 15, 20],
          "searching": true,
          "ordering": true,
          "info": false,
          "autoWidth": false,
          'columnDefs': [{
            'orderable': false,
            'targets': [0, 4]
          }]
        });*/
      });
    </script>
  @endpush
@endif