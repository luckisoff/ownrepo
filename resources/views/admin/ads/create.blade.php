@extends('admin.layouts.app')

@section('title', $edit ? 'Edit '.$model->title.' ' : 'Add a New '.ucfirst($routeType))

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
        <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }} <b>{{ ucfirst($routeType) }}</b></h4>
      </div>

      <div class="card-content">

        <div class="row">
          <div class="col-md-2">
            @if($edit)
              @include('extras.input_image', ['input_image'=>$model->image(200,200), 'image_name_field'=>'image'])
            @else
              @include('extras.input_image')
            @endif
          </div>
          <div class="col-md-10">
            {{--title--}}
            <div class="form-group {{ $errors->has('title')?'has-error':'' }}">
              <label for="title">{{ ucwords('title') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="title"
                     name="title"
                     required="true"
                     value="{{$edit?$model->title:old('title')}}"/>
              @include('extras.error_message',['errorName' => 'title'])
            </div>
            {{--./title--}}

            {{--slug--}}
            <div class="form-group {{ $errors->has('slug')?'has-error is-focused':'' }}">
              <label for="slug">{{ ucwords('slug') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="slug"
                     name="slug"
                     required="true"
                     value="{{$edit?old('slug')??$model->slug:old('slug')}}"/>
              @include('extras.error_message',['errorName' => 'slug'])
            </div>
            {{--./slug--}}

            {{--contact--}}
            <div class="form-group {{ $errors->has('contact')?'has-error':'' }}">
              <label for="contact">{{ ucwords('contact number') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="contact"
                     name="contact"
                     required="true"
                     value="{{$edit?$model->contact:old('contact')}}"/>
              @include('extras.error_message',['errorName' => 'contact'])
            </div>
            {{--./contact--}}

            {{--email--}}
            <div class="form-group {{ $errors->has('email')?'has-error':'' }}">
              <label for="email">{{ ucwords('email') }}
                <small>*</small>
              </label>
              <input type="email"
                     class="form-control"
                     id="email"
                     name="email"
                     required="true"
                     value="{{$edit?$model->email:old('email')}}"/>
              @include('extras.error_message',['errorName' => 'email'])
            </div>
            {{--./email--}}

            {{--description--}}
            <div class="form-group {{ $errors->has('description')?'has-error is-focused':'' }}">
              <label for="description">Description
                <small>*</small>
              </label>
              <textarea class="form-control asdh-tinymce"
                        id="description"
                        name="description"
                        rows="10">{{$edit?$model->description:old('description')}}</textarea>
              @include('extras.error_message',['errorName' => 'description'])
            </div>
            {{--./description--}}

            {{--submit--}}
            <div class="text-right">
              <button type="submit"
                      class="btn btn-success btn-fill btn-prevent-multiple-submit">{{ $edit?'Update':'Save' }}</button>
            </div>
          </div>
        </div>

      </div>

    </div>
  </form>
@endsection

@push('script')
  @include('extras.tinymce')
  @if(!$edit)
    <script>
      $(document).ready(function () {
        var $title = $('#title'), $slug = $('#slug');

        $title.on('keyup', function () {
          $slug.val(convertToSlug($(this).val()));
        });

        $title.on('blur', function () {
          $slug.val(convertToSlug($(this).val()));
        });

      });
    </script>
  @endif
@endpush