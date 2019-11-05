@extends('admin.layouts.app')

@section('title', $edit ? 'Edit '.$model->name.' ' : 'Add a New '.ucfirst($routeType))

@push('css')
  <style>
    .images-container > div {
      display      : inline-block;
      margin-right : 80px;
    }
  </style>
@endpush

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
            <div class="images-container text-center">
              @if($edit)
                @include('extras.input_image', ['input_image'=>$model->image(200,200), 'image_name_field'=>'image'])
                @include('extras.input_image', ['input_image'=>$model->image(200,200,'background_image'), 'image_name_field'=>'background_image'])
                @include('extras.input_image', ['input_image'=>$model->image(200,200,'ad_image'), 'image_name_field'=>'ad_image'])
              @else
                @include('extras.input_image')
                @include('extras.input_image',['image_name_field'=>'background_image'])
                @include('extras.input_image', ['image_name_field'=>'ad_image'])
              @endif
            </div>

            {{--name--}}
            <div class="form-group">
              <label for="name">Name
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="name"
                     name="name"
                     required="true"
                     placeholder="Enter Sponsors Name"
                     value="{{$edit?$model->name:old('name')}}"/>
            </div>
            {{--./name--}}
            <div class="form-group">
                <label for="Prize">Prize
                  <small>*</small>
                </label>
                <input type="text"
                       class="form-control"
                       id="prize"
                       name="prize"
                       required="true"
                       placeholder="Enter Sponsors Prize"
                       value="{{$edit?$model->prize:old('prize')}}"/>
              </div>
            {{--facebook_id--}}
              <div class="form-group">
                <label for="facebook-id">Facebook ID
                </label>
                <input type="text"
                      class="form-control"
                      id="facebook-id"
                      name="facebook_id"
                      placeholder="Optional"
                      value="{{$edit?$model->facebook_id:old('facebook_id')}}"/>
              </div>
            {{--./facebook_id--}}

            {{--submit--}}
            <div class="text-right">
              <button type="submit"
                      class="btn btn-success btn-fill btn-prevent-multiple-submit">{{ $edit?'Update':'Add' }}</button>
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