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
        <h4 class="card-title">
          @if($edit)
            Update <b>{{ $model->question }}</b>
          @else
            Add a new <b>Question</b>
          @endif
        </h4>
      </div>

      <div class="card-content">
        {{--question--}}
        <div class="form-group {{ $edit?null:'label-floating' }}">
          <label class="control-label" for="question"><b>{{ ucwords('question in English') }}</b>
            <small>* (Do not add question no. here)</small>
          </label>
          <input type="text"
                 class="form-control"
                 id="question"
                 name="question"
                 required="true"
                 value="{{$edit?$model->question:old('question')}}"/>
        </div>
        {{--./question--}}

        {{--question_nepali--}}
        <div class="form-group {{ $edit?null:'label-floating' }}">
          <label class="control-label" for="question_nepali"><b>{{ ucwords('question in Nepali') }}</b>
            <small>* (Do not add question no. here)</small>
          </label>
          <input type="text"
                 class="form-control"
                 id="question_nepali"
                 name="question_nepali"
                 required="true"
                 value="{{$edit?optional($model->nepali())->question:old('question_nepali')}}"/>
        </div>
        {{--./question--}}

        <div style="margin-top: 50px;">
          <label for=""><b>Answers</b>
            <small>(Enter answers in the correct order.)</small>
          </label>

          <div class="row">
            {{--options--}}
            @for($i=0;$i<4;$i++)
              <div class="col-sm-6">
                <div class="form-group">
                  <input type="text"
                         class="form-control"
                         id="option{{$i}}"
                         name="options[]"
                         placeholder="Option {{$i+1}}* in English"
                         value="{{ $edit?$model->cached_options[$i]->option:null }}"
                         required="true"/>
                </div>
              </div>
            @endfor
            {{--./options--}}
          </div>

          <div class="row" style="margin-top: 30px;">
            {{--options_nepali--}}
            @for($i=0;$i<4;$i++)
              <div class="col-sm-6">
                <div class="form-group">
                  <input type="text"
                         class="form-control"
                         id="option_nepali{{$i}}"
                         name="options_nepali[]"
                         placeholder="Option {{$i+1}}* in Nepali"
                         value="{{ $edit?optional(optional($model->options[$i])->nepali())->option:null }}"
                         required="true"/>
                </div>
              </div>
            @endfor
            {{--./options_nepali--}}
          </div>
        </div>

        {{--submit--}}
        <div class="text-right">
          <button type="submit"
                  class="btn btn-success btn-fill btn-prevent-multiple-submit">{{ $edit?'Update':'Add' }}</button>
        </div>

      </div>
    </div>

  </form>
@endsection

@push('script')
  <script>
    $(document).ready(function () {

    });
  </script>
@endpush