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
                <label for="price">{{ ucwords('point') }}
                </label>
                <input type="number"
                       class="form-control"
                       id="point"
                       name="point"
                       value="{{$edit?$model->point:old('point')}}"/>
              </div>
           
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