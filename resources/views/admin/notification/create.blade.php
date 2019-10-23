@extends('admin.layouts.app')

@section('title', $edit ? 'Edit '.$model->name.' ' : 'Add a New '.ucfirst($routeType))

@section('content')

  <form action="{{$edit?route($routeType.'.update',$model):route($routeType.'.store')}}"
        method="post"
        enctype="multipart/form-data"
        class="from-prevent-multiple-submit"
        id="TypeValidation">
    {{csrf_field()}}
    {{$edit?method_field('PUT'):''}}
    <div class="card">

      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }} {{ ucfirst($routeType) }}</h4>
      </div>

      <div class="card-content">

        <div class="row">
          <div class="col-md-12">
            {{--title--}}
            <div class="form-group">
              <label class="control-label" for="title">{{ ucwords('title') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="title"
                     name="title"
                     required="true"
                     value="{{$edit?$model->title:old('title')}}"/>
            </div>
            {{--./title--}}

            {{--body--}}
            <div class="form-group">
              <label class="control-label" for="body">{{ ucwords('body') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="body"
                     name="body"
                     required="true"
                     value="{{$edit?$model->body:old('body')}}"/>
            </div>
            {{--./body--}}

            {{--submit--}}
            <div class="text-right">
              <button type="submit"
                      class="btn btn-success btn-fill btn-prevent-multiple-submit">{{ $edit?'Update':'Send' }}</button>
            </div>
          </div>
        </div>

      </div>

    </div>
  </form>
@endsection

@push('script')
  @include('extras.tinymce')
  <script>
    $(document).ready(function () {

    });
  </script>
@endpush