@extends('admin.layouts.app')

@section('title', 'Upload question via excel')

@section('content')
  <form action="{{ route($routeType.'.upload-excel.store') }}"
        method="post"
        enctype="multipart/form-data"
        class="from-prevent-multiple-submit"
        id="TypeValidation">
    {{ csrf_field() }}
    <div class="card">

      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title"><b>Upload questions via excel</b></h4>
      </div>

      <div class="card-content">
        {{--excel_file--}}
        <div class="form-group">
          <label for="excel">Upload excel file</label>
          <input type="text" class="form-control" readonly>
          <input type="file"
                 class="form-control"
                 name="excel_file"
                 id="excel"
                 accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
        </div>
        {{--./excel_file--}}

        {{--submit--}}
        <div class="text-center">
          <button type="submit"
                  class="btn btn-success btn-fill btn-prevent-multiple-submit">Upload
          </button>
        </div>

      </div>
    </div>

  </form>
@endsection

@push('script')
  <script>

  </script>
@endpush