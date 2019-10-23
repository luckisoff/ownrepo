@extends('admin.layouts.app')

@section('title', $edit ? 'Edit '.$model->name.' ' : 'Add a New '.ucfirst($routeType))

@push('css')
  <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
  <style>
    .file-thumbnail-footer {
      display : none;
    }

    .krajee-default.file-preview-frame .kv-file-content {
      height : 160px;
    }

    .gallery-image-container {
      display      : inline-block;
      position     : relative;
      margin-right : 10px;
    }

    .gallery-image-container img {
      width  : 160px;
      height : 200px;
    }

    .gallery-image-container .delete-gallery-image {
      position   : absolute;
      top        : 0;
      right      : 0;
      color      : #fff;
      background : green;
      cursor     : pointer;
    }

    .gallery-image-container .delete-gallery-image:hover {
      background : red;
    }
  </style>
@endpush

@section('content')

  <form action="{{$edit?route($routeType.'.update',[$model,'type'=>request()->query('type')]):route($routeType.'.store',['type'=>request()->query('type')])}}"
        method="post"
        enctype="multipart/form-data"
        class="from-prevent-multiple-submit"
        id="TypeValidation">
    {{csrf_field()}}
    {{$edit?method_field('PUT'):''}}
    <div class="card">

      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }}
          <b>{{ getNewsFeedName() }}</b></h4>
      </div>

      <div class="card-content">

        <div class="row">
          @if(!request()->has('type'))
            <div class="col-md-2">
              @if($edit)
                @include('extras.input_image', ['input_image'=>optional($model->images->first())->image(200,200), 'image_name_field'=>'image'])
              @else
                @include('extras.input_image')
              @endif
            </div>
          @endif
          <div class="{{ !request()->has('type') ?'col-md-10':'col-md-12' }}">

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

            {{--slug--}}
            <div class="form-group">
              <label class="control-label" for="slug">{{ ucwords('slug') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="slug"
                     name="slug"
                     required="true"
                     value="{{$edit?$model->slug:old('slug')}}"/>
            </div>
            {{--./slug--}}

            @if(request()->query('type') === 'video')
              {{--url--}}
              <div class="form-group">
                <label class="control-label" for="url">{{ ucwords('youtube url') }}
                  <small>*</small>
                </label>
                <input type="url"
                       class="form-control"
                       id="url"
                       name="url"
                       required="true"
                       value="{{$edit?$model->youtube_url:old('url')}}"/>
              </div>
              {{--./url--}}
            @endif

            @if(request()->query('type')==='gallery')
              <div class="form-group image">
                <label for="images" class="control-label">Insert Images
                  <small>(Max: 5)</small>
                </label>
                <input type="file"
                       accept="image/*"
                       class="form-control-file file-loading"
                       id="images"
                       aria-describedby="fileHelp"
                       multiple
                       name="images[]">
                <small id="fileHelp" class="form-text text-muted">Each image must be of size less than 5MB</small>
              </div>

              @if($edit)
                @foreach($model->images as $image)
                  <div class="gallery-image-container" id="parent-gallery-{{ $image->id }}">
                    <div class="material-icons delete-gallery-image"
                         title="Delete"
                         data-hide="#parent-gallery-{{ $image->id }}"
                         data-url="{{ route('ajax.gallery-image.delete',$image) }}">clear
                    </div>
                    <img src="{{ $image->image(160,200) }}" alt="{{ $image->caption }}">
                  </div>
                @endforeach
              @endif
            @endif

            @if(!request()->has('type'))
              {{--description--}}
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control asdh-tinymce"
                          id="description"
                          name="description"
                          rows="10">{{$edit?$model->description:old('description')}}</textarea>
              </div>
              {{--./description--}}
            @endif

            {{--submit--}}
            <div class="text-right">
              <button type="submit"
                      class="btn btn-success btn-fill btn-prevent-multiple-submit">{{ $edit?'Update':'Add' }}</button>
            </div>
            {{--./submit--}}
          </div>
        </div>

      </div>

    </div>
  </form>
@endsection

@push('script')
  @include('extras.tinymce')
  <script src="{{ asset('public/plugins/bootstrap-fileinput/js/fileinput.js') }}"></script>
  <script>
    $(document).ready(function () {
      @if(!$edit)

      $('#title').on('keyup', function () {
        $('#slug').val(convertToSlug($(this).val()));
      });
      $('#title').on('blur', function () {
        $('#slug').val(convertToSlug($(this).val()));
      });

      @else

      $('.delete-gallery-image').on('click', function (event) {
        event.preventDefault();
        if (confirm("Are you sure?")) {
          var $this = $(this);
          $.ajax({
            method : 'POST',
            url    : $this.data('url'),
            success: function (data) {
              $($this.data('hide')).fadeOut().remove();
              showAlertMessageSuccess(data.message);
            },
            error  : function (data) {
              // alert(1);
              console.log('Error: ', data);
            }
          });
        }
      });

          @endif


      var $images = $("#images");

      $images.fileinput({
        previewFileType: "image",
        browseIcon     : "<i class=\"glyphicon glyphicon-picture\"></i> ",
        showUpload     : false,
        maxFileSize    : 1024 * 5,
        maxFileCount   : 5
      });

      $images.change(function () {
        setTimeout(function () {
          $('.kv-file-content').after('<input class="form-control" placeholder="Enter Caption here..." name="caption[]" type="text">');
        }, 1000);
      });
    });
  </script>
@endpush