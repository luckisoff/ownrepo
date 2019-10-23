@extends('admin.layouts.app')

@section('title', $edit ? 'Edit '.$model->level.' ' : 'Add a New '.ucfirst($routeType))

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
          <div class="col-md-3">
            <label for="">Sponser Image</label>
            @if($edit)
              @include('extras.input_image', ['input_image'=>$model->image(200,200,'sponser_image'), 'image_name_field'=>'sponser_image', 'center'=>false])
            @else
              @include('extras.input_image', ['image_name_field'=>'sponser_image', 'center'=>false])
            @endif
          </div>

          <div class="col-md-9">
            {{--level--}}
            <div class="form-group label-floating m-bottom-20">
              <label class="control-label" for="level">Level
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="level"
                     name="level"
                     required="true"
                     value="{{$edit?$model->level:old('level')}}"/>
            </div>
            {{--./level--}}

            {{--duration--}}
            <div class="form-group label-floating m-bottom-20">
              <label class="control-label" for="duration">{{ ucwords('duration') }}
                <small>(in seconds)</small>
              </label>
              <input type="number"
                     class="form-control"
                     id="duration"
                     name="duration"
                     min="0"
                     value="{{$edit?$model->duration:old('duration')}}"/>
            </div>
            {{--./duration--}}

            {{--price--}}
            <div class="form-group label-floating m-bottom-20">
              <label class="control-label" for="price">{{ ucwords('price') }}
                <small>*</small>
              </label>
              <input type="number"
                     class="form-control"
                     id="price"
                     name="price"
                     required="true"
                     min="0"
                     value="{{$edit?$model->price:old('price')}}"/>
            </div>
            {{--./price--}}

            {{--point--}}
            <div class="form-group label-floating">
              <label class="control-label" for="point">{{ ucwords('point') }}
                {{--<small>*</small>--}}
              </label>
              <input type="number"
                     class="form-control"
                     id="point"
                     name="point"
                     {{--required="true"--}}
                     min="0"
                     value="{{$edit?$model->point:old('point')}}"/>
            </div>
            {{--./point--}}

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
  <script>
    $(document).ready(function () {
      $('#level').focus();

      @if(!$edit)
      /*Add and remove multiple fields starts*/
      var html = '', multipleAddLimitStart = 1, multipleAddLimitEnd = 5;

      html += '<div class="form-group asdh-remove_margin_padding_from_add_remove_multiple">';
      html += ' <input type="text" class="form-control" name="add_more[]" placeholder="Other Add More Name" required="true" />';
      html += ' <span class="asdh-add_remove_multiple remove" title="Remove"><i class="material-icons">delete</i></span>';
      html += '</div>';

      $('.asdh-add_remove_multiple.add').on('click', function (e) {
        e.preventDefault();
        var $appendTo = $('.asdh-add_multiple_container');
        if (multipleAddLimitStart < multipleAddLimitEnd) {
          $($appendTo).append(html);
          multipleAddLimitStart++;
        } else {
          alert('Limit reached.')
        }

        $('.asdh-add_remove_multiple.remove').on('click', function (e) {
          e.preventDefault();
          $(this).parent().remove();
          // I am assigning this value to multipleAddLimitStart because when remove button is clicked,
          // the event triggers for the number of html added to the container.
          multipleAddLimitStart = $appendTo.children().length;
        });
      });
      /*Add and remove multiple fields ends*/
      @endif

    });
  </script>
@endpush