@extends('admin.layouts.app')

@section('title', $edit ? 'Edit '.$model->title : 'Add a New '.ucfirst($routeType))

@push('css')
  <style>
    .add-new-category {
      display : none;
    }
  </style>
@endpush

@section('content')

  <form action="{{$edit?route($routeType.'.update',$model):route($routeType.'.store')}}"
        method="post"
        enctype="multipart/form-data"
        id="TypeValidation">
    {{csrf_field()}}
    {{$edit?method_field('PUT'):''}}
    <div class="card">

      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">{{ $edit?'Edit':'Add a New' }} Page</h4>
      </div>

      <div class="card-content">

        <div class="row">

          <div class="col-md-3">
            {{--image--}}
            @if($edit)
              @include('extras.input_image', ['input_image'=>$model->image(140,140)])
            @else
              @include('extras.input_image')
            @endif
            {{--./image--}}

            <div class="form-group">
              <label for="">Others</label>
              {{--active--}}
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="active" value="1" {{ $edit?($model->active?'checked':''):'checked' }}>
                  Active
                </label>
              </div>
              {{--./active--}}

              {{--home--}}
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="home" value="1" {{ $edit?($model->home?'checked':''):'' }}>
                  Home
                </label>
              </div>
              {{--./home--}}
            </div>

          </div>

          <div class="col-md-9">

            {{-- title --}}
            <div class="form-group label-floating">
              <label class="control-label" for="title">Title
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="title"
                     name="title"
                     required="true"
                     value="{{$edit?$model->title:old('title')}}"/>
            </div>
            {{-- ./title --}}

            {{-- slug --}}
            <div class="form-group {{ $edit?:'label-floating' }}">
              <label class="control-label" for="slug">Slug
                <small>* {{ $edit?'(Changing the slug will adversely affect SEO of your Website)':'' }}</small>
              </label>
              <input type="text"
                     name="slug"
                     id="slug"
                     class="form-control"
                     required="true"
                     maxlength="191"
                     value="{{ $edit?$model->slug:old('slug') }}"/>
            </div>
            {{-- ./slug --}}

            {{-- description --}}
            <div class="form-group">
              <label for="description">Description *</label>
              <textarea class="form-control asdh-tinymce"
                        id="description"
                        name="description"
                        rows="15">{{$edit?$model->description:old('description')}}</textarea>
            </div>
            {{-- ./description --}}

          </div>
        </div>

        {{-- submit --}}
        <div class="text-right">
          <button type="submit" class="btn btn-success btn-fill">{{ $edit?'Update':'Publish' }}</button>
        </div>
        {{-- ./submit --}}

      </div>
    </div>
  </form>
@endsection

@push('script')
  @include('extras.tinymce')
  <script>
    $(document).ready(function () {
      var $addNewCategory = $('#add-new-category'),
        $createCategorySubmit = $('#create-category-submit'),
        $category = $('#asdh-category'),
        $categoryNameAjax = $('#category_name'),
        $title = $('#title');

      $addNewCategory.on('click', function (e) {
        e.preventDefault();
        $($(this).data('toggle-class')).toggle();
      });

      $createCategorySubmit.on('click', function (e) {
        e.preventDefault();
        if ($categoryNameAjax.val() === "") {
          alert("Category name field cannot be empty");
        } else {
          $.ajax({
            'type': 'post',
            'url': $(this).data('url'),
            'data': {'name': [$categoryNameAjax.val()]},
            'success': function (data) {
              $category.append('<option value="' + data.id + '" selected>' + data.name + '</option>');
              $category.selectpicker('refresh');
            },
            'error': function (data) {
              console.log('Error ' + data);
            }
          });
        }
      });

      @if(!$edit)
      $title.blur(function () {
        makeSlug($(this).val(), $('#slug'));
      });
      @endif
    });
  </script>
@endpush