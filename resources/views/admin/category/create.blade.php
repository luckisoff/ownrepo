@extends('admin.layouts.app')

@section('title', 'Add a new category')

@section('content')

  <form action="{{$edit?route('category.update',$category):route('category.store')}}"
        method="post"
        enctype="multipart/form-data"
        id="TypeValidation"
        class="from-prevent-multiple-submit">
    {{csrf_field()}}
    {{$edit?method_field('PUT'):''}}
    <div class="card">

      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">{{$edit?'Edit':'Add a New'}} Category</h4>
      </div>

      <div class="card-content">

        <div class="asdh-add_multiple_container">
          <div class="row">

            @if($edit)
              <div class="col-md-6">
                @include('extras.input_image', ['input_image'=>$category->image(140,140), 'image_name_field' => 'image'])
              </div>
              <div class="col-md-6">
                @include('extras.input_image', ['input_image'=>$category->image(140,140,'icon'), 'image_name_field' => 'icon'])
              </div>
            @else
              <div class="{{ $edit?'col-md-12':'col-md-3' }}">
                <div class="form-group">
                  <input type="file" id="image" name="{{ $edit?'image':'image[]' }}">
                  <input type="text" readonly="" class="form-control" placeholder="Image">
                </div>
              </div>
              <div class="{{ $edit?'col-md-12':'col-md-3' }}">
                <div class="form-group">
                  <input type="file" id="icon" name="{{ $edit?'icon':'icon[]' }}">
                  <input type="text" readonly="" class="form-control" placeholder="Icon">
                </div>
              </div>
            @endif

            <div class="{{ $edit?'col-md-12':'col-md-6' }}">
              {{--color--}}
              <div class="form-group label-floating">
                <label class="control-label" for="color">{{ ucwords('color') }}
                  <small>(Eg. #123654)</small>
                </label>
                <input type="text"
                       class="form-control"
                       id="color"
                       name="{{ $edit?'color':'color[]' }}"
                       value="{{$edit?$category->color:old('color')}}"/>
              </div>
              {{--./color--}}
            </div>

            <div class="{{ $edit?'col-md-12':'col-md-6' }}">
              {{--name--}}
              <div class="form-group label-floating">
                <label class="control-label" for="name">Category Name</label>
                <input type="text"
                       class="form-control category-name"
                       id="name"
                       name="{{$edit?'name':'name[]'}}"
                       value="{{$edit?$category->name:''}}"
                       data-make-slug-on=".category-slug-first"
                       required="true"/>
              </div>
              {{--./name--}}
            </div>

            <div class="{{ $edit?'col-md-12':'col-md-6' }}">
              {{--slug--}}
              <div class="form-group label-floating">
                <label class="control-label" for="slug">Slug
                  <small>{{ $edit?'(Changing slug will adversely affect the seo of you website.)':'' }}</small>
                </label>
                <input type="text"
                       class="form-control category-slug-first"
                       id="slug"
                       name="{{$edit?'slug':'slug[]'}}"
                       value="{{$edit?$category->slug:''}}"
                       required="true"/>
                @if(!$edit)
                  <span class="asdh-add_remove_multiple add" title="Add">
                <i class="material-icons">add_circle</i>
              </span>
                @endif
              </div>
              {{--./slug--}}
            </div>

          </div>
        </div>

        {{--submit--}}
        <div class="form-footer text-right">
          <button type="submit"
                  class="btn btn-success btn-fill btn-prevent-multiple-submit">{{$edit?'Update':'Add'}}</button>
        </div>

      </div>

    </div>
  </form>
@endsection

@push('script')
  <script>
    $(document).ready(function () {

      @if(!$edit)
      /*Add and remove multiple fields starts*/
      var html = '', multipleAddLimit = 1;


      $('.asdh-add_remove_multiple.add').on('click', function (e) {
        e.preventDefault();
        var $appendTo = $('.asdh-add_multiple_container');
        if (multipleAddLimit < 5) {
          html += '<div class="row" style="margin-top:30px;">';

          html += '<div class="col-md-3">';
          html += '<div class="form-group asdh-remove_margin_padding_from_add_remove_multiple">';
          html += '<input type="file" name="image[]">';
          html += '<input type="text" readonly="" class="form-control" placeholder="Other Image">';
          html += '</div>';
          html += '</div>';

          html += '<div class="col-md-3">';
          html += '<div class="form-group asdh-remove_margin_padding_from_add_remove_multiple">';
          html += '<input type="file" name="icon[]">';
          html += '<input type="text" readonly="" class="form-control" placeholder="Other Icon">';
          html += '</div>';
          html += '</div>';

          html += '<div class="col-md-6">';
          html += '<div class="form-group asdh-remove_margin_padding_from_add_remove_multiple">';
          html += '<input type="text" class="form-control" name="color[]" placeholder="Other color"/>';
          html += '</div>';
          html += '</div>';

          html += '<div class="col-md-6">';
          html += '<div class="form-group asdh-remove_margin_padding_from_add_remove_multiple">';
          html += ' <input type="text" class="form-control category-name" name="name[]" placeholder="Other Category Name" required="true" data-make-slug-on=".category-slug-first' + multipleAddLimit + '" />';
//      html += ' <span class="asdh-add_remove_multiple remove" title="Remove"><i class="material-icons">delete</i></span>';
          html += '</div>';
          html += '</div>';

          html += '<div class="col-md-6">';
          html += '<div class="form-group asdh-remove_margin_padding_from_add_remove_multiple">';
          html += ' <input type="text" class="form-control category-slug-first' + multipleAddLimit + '" name="slug[]" placeholder="Other Category Slug" required="true" />';
          html += ' <span class="asdh-add_remove_multiple remove" title="Remove"><i class="material-icons">delete</i></span>';
          html += '</div>';
          html += '</div>';

          html += '</div>';
          $($appendTo).append(html);
          html = '';
          multipleAddLimit++;
        } else {
          alert('Limit reached.')
        }

        $('.asdh-add_remove_multiple.remove').on('click', function (e) {
          e.preventDefault();
          $(this).parent().parent().parent().remove();
          // I am assigning this value to multipleAddLimit because when remove button is clicked,
          // the event triggers for the number of html added to the container.
          multipleAddLimit = $appendTo.children().length;
        });

        var $categoryName = $('.category-name');
        $categoryName.blur(function () {
          var $categorySlug = $($(this).data('make-slug-on'));
          makeSlug($(this).val(), $categorySlug);
        });

      });
      /*Add and remove multiple fields ends*/
          @endif



          @if(!$edit)
      var $categoryName = $('.category-name');
      $categoryName.blur(function () {
        var $categorySlug = $($(this).data('make-slug-on'));
        makeSlug($(this).val(), $categorySlug);
      });
      @endif

    });
  </script>
@endpush