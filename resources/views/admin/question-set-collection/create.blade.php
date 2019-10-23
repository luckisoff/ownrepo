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
        <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }} <b>Question set collection</b></h4>
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
          <div class="col-md-9" style="margin-top:13px;">

            {{--title--}}
            <div class="form-group label-floating">
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

            {{--icon--}}
            <div class="form-group">
              <input type="file" id="question_set_collection_icon" name="{{ 'icon' }}">
              <input type="text" readonly="" class="form-control" placeholder="Icon">
              @if($edit)
                <img src="{{ $model->image(50,50,'icon') }}" alt="" style="width:50px;position:absolute;top:0;right:0;">
              @endif
            </div>
            {{--./icon--}}

            {{--color--}}
            <div class="form-group label-floating">
              <label class="control-label" for="color">{{ ucwords('color') }}
                <small>(Eg. #123654)</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="color"
                     name="color"
                     value="{{$edit?$model->color:old('color')}}"/>
            </div>
            {{--./color--}}

            {{--show on--}}
            <div class="form-group">
              <label class="control-label" for="show_on">
                Show on
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control datepicker"
                     id="show_on"
                     name="show_on"
                     value="{{$edit?$model->show_on->format('m/d/Y'):old('show_on')}}"/>
            </div>
            {{--./show on--}}

            {{--submit--}}
            <div class="text-right" style="margin-top:30px;">
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
      $('.datepicker').datetimepicker({
        format: 'MM/DD/YYYY',
        icons : {
          time    : "fa fa-clock-o",
          date    : "fa fa-calendar",
          up      : "fa fa-chevron-up",
          down    : "fa fa-chevron-down",
          previous: 'fa fa-chevron-left',
          next    : 'fa fa-chevron-right',
          today   : 'fa fa-screenshot',
          clear   : 'fa fa-trash',
          close   : 'fa fa-remove'
        }
      });
    });
  </script>
@endpush