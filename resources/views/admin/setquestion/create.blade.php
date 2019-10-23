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
        <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }} <b>Question Set</b></h4>
      </div>

      <div class="card-content">

        <div class="row">
          <div class="col-md-10">

            {{--title--}}
            <div class="form-group">
              <label for="name">{{ ucwords('name') }}
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="name"
                     name="name"
                     required="true"
                     value="{{$edit?$model->name:old('name')}}"/>
            </div>

            <div class="form-group">
                <label for="price">{{ ucwords('price') }}
                </label>
                <input type="number"
                       class="form-control"
                       id="price"
                       name="price"
                       value="{{$edit?$model->price:old('price')}}"/>
              </div>

              @if($edit)
                <div class="form-group">
                    <label for="sttus">{{ ucwords('status') }}
                    </label>
                    <select name="status" class="form-control">
                        <option value="1" {{$model->status==1?'selected':''}}>Active</option>
                        <option value="0" {{$model->status==0?'selected':''}}>Deactive</option>
                    </select>
                </div>
              @endif
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

            {{-- <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">Start time
                    <span>*</span>
                  </label>
                  <input type="text"
                         class="form-control datetimepicker"
                         value="{{ $edit?$model->start_time->format('m/d/Y h:i A'):old('start_time') }}"
                         name="start_time"
                         required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">End time
                    <span>*</span>
                  </label>
                  <input type="text"
                         class="form-control datetimepicker"
                         value="{{ $edit?$model->end_time->format('m/d/Y h:i A'):old('end_time') }}"
                         name="end_time"
                         required>
                </div>
              </div>
            </div> --}}

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