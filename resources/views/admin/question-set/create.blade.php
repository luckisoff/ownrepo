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
        <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }} <b>Live Quiz</b></h4>
      </div>

      <div class="card-content">

        <div class="row">
          <div class="col-md-2">
            @if($edit)
              @include('extras.input_image', ['image_name_field'=>'sponser_image', 'center'=>false, 'display_name' => 'background image'])
              @else
              @include('extras.input_image', ['image_name_field'=>'sponser_image', 'center'=>false, 'display_name' => 'background image'])
            @endif
          </div>
          <div class="col-md-10">

            {{--title--}}
            <div class="form-group">
              <label for="title">{{ ucwords('title') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="title"
                     name="title"
                     required="true"
                     value="{{$edit?$model->title:old('title')}}"
                     placeholder="Enter live quize title"/>
            </div>
            {{--./title--}}

            {{--icon--}}
            {{--<div class="form-group">
              <input type="file" id="question_set_icon" name="{{ 'icon' }}">
              <input type="text" readonly="" class="form-control" placeholder="Icon">
              @if($edit)
                <img src="{{ $model->image(50,50,'icon') }}" alt="" style="width:50px;position:absolute;top:0;right:0;">
              @endif
            </div>--}}
            {{--./icon--}}

            {{--color--}}
            {{-- <div class="form-group">
              <label for="color">{{ ucwords('pick color') }}</label>
              <input type="color"
                     class="form-control"
                     id="color"
                     name="color"
                     value="{{$edit?$model->color:old('color')??'#ffffff'}}"/>
            </div> --}}
            {{--./color--}}

            <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="label-control">Timer
                      <span>*</span>
                    </label>
                    <input type="text"
                           class="form-control datetimepicker"
                           value="{{ $edit?(isset($model->counter)?\Carbon\Carbon::parse($model->counter)->format('m/d/Y h:i A'):''):old('counter') }}"
                           name="timer"
                           required
                           placeholder="Enter timer">
                  </div>
                </div>
              </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">Start time
                    <span>*</span>
                  </label>
                  <input type="text"
                         class="form-control datetimepicker"
                         value="{{ $edit?\Carbon\Carbon::parse($model->start_time)->format('m/d/Y h:i A'):old('start_time') }}"
                         name="start_time"
                         required
                         placeholder="Enter start time">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">End time
                  </label>
                  <input type="text"
                         class="form-control datetimepicker"
                         value="{{ $edit?\Carbon\Carbon::parse($model->end_time)->format('m/d/Y h:i A'):old('end_time') }}"
                         name="end_time"
                         placeholder="Enter end time">
                </div>
              </div>
              @if(count($sponsors)>0)
              <div class="col-md-12">
                  <div class="form-group">
                    <label class="label-control">Sponsor Name
                    </label>
                    <select name="sponsor" id="sponsor" class="form-control">
                      <option value="">Choose Sponser</option>
                      @foreach($sponsors as $sponsor)
                        <option value="{{$sponsor->id}}">{{$sponsor->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @endif
              <div class="col-md-12">
                  <div class="form-group">
                    <label class="label-control">Prize
                    </label>
                    <input type="text"
                           class="form-control"
                           value="{{ $edit?($model->prize?$model->prize:''):old('prize') }}"
                           name="prize"
                           placeholder="Enter prize if no sponsors">
                  </div>
                </div>
            </div>

            {{--submit--}}
            <div class="text-right" style="margin-top: 30px;">
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
      $('.datetimepicker').datetimepicker({
        icons: {
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