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
          @if(request()->has('question_set_id'))
            Add new question to <b>{{ $current_question_set->title }}</b>
          @elseif(request()->has('setquestion_id'))
            Add new question to <b>{{ $setquestion->name }}</b>
          @else
            Add a new <b>Question</b>
          @endif
        </h4>
      </div>
      @if(request()->has('sponsor_id'))
        <a href="{{ route('sponsor.show', request()->sponsor_id) }}"
           class="btn btn-success btn-round btn-xs create-new">
          <i class="material-icons">remove_red_eye</i> View all questions of
          <b>{{ $sponsors->find(request()->sponsor_id)->name }}</b>
        </a>
      @elseif(request()->has('question_set_id'))
        <a href="{{ route('question-set.show', request()->question_set_id) }}"
           class="btn btn-success btn-round btn-xs create-new">
          <i class="material-icons">remove_red_eye</i> View all questions of
          <b>{{ $question_sets->find(request()->question_set_id)->title }}</b>
        </a>
        @elseif(request()->has('setquestion_id'))
        <a href="{{ route('question.show', request()->setquestion_id) }}"
           class="btn btn-success btn-round btn-xs create-new">
          <i class="material-icons">remove_red_eye</i> View all questions of
          <b>{{ $setquestion->find(request()->setquestion_id)->name }}</b>
        </a>
      @endif

      <div class="card-content">
        @if(!request()->has('sponsor_id'))
          @if(is_null(request()->question_set_id))
            <div class="row">
              <div class="col-md-3">
                {{-- difficulty_level --}}
                <div class="form-group asdh-select">
                  <label for="difficulty_level">Difficulty Level / Question No.</label>
                  <select name="difficulty_level_id"
                          id="difficulty_level"
                          class="selectpicker"
                          data-style="select-with-transition"
                          {{--title="Select Category"--}}
                          data-live-search="true"
                          required="true"
                          data-size="5">
                    <option value="">Select Difficulty Level / Question No.</option>
                    @foreach($difficulty_levels as $difficulty_level)
                      <option value="{{ $difficulty_level->id }}" {{ $edit?$difficulty_level->id==$model->difficulty_level_id?'selected':'':'' }}>{{ $difficulty_level->level }}</option>
                    @endforeach
                  </select>
                  <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
                </div>
                {{-- ./difficulty_level --}}
              </div>
              <div class="col-md-3">
                {{-- categories --}}
                <div class="form-group asdh-select">
                  <label for="question_category">Category</label>
                  <select name="category_id"
                          id="question_category"
                          class="selectpicker"
                          data-style="select-with-transition"
                          {{--title="Select Category"--}}
                          data-live-search="true"
                          required="true"
                          data-size="5">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ $edit?$category->id==$model->category_id?'selected':'':'' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                  <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
                </div>
                {{-- ./categories --}}
              </div>

              <div class="col-md-3">
                <div class="form-group asdh-select">
                  <label for="difficulty_level">Question Set</label>
                  <select name="setquestion_id"
                          id="setquestion_id"
                          class="selectpicker"
                          data-style="select-with-transition"
                          {{--title="Select Category"--}}
                          data-live-search="true"
                          required="true"
                          data-size="5">
                    <option value="">Select Question Set / Level</option>
                    @foreach($setquestion as $question)
                      <option value="{{ $question->id }}" {{ $edit?$question->id==$model->setquestion_id?'selected':'':'' }}>{{ $question->name }}</option>
                    @endforeach
                  </select>
                  <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-group asdh-select">
                  <label for="difficulty_level">Question Type</label>
                  <select name="question_type_id"
                          id="question_type_id"
                          class="selectpicker"
                          data-style="select-with-transition"
                          data-live-search="true"
                          required="true"
                          data-size="5">
                    <option value="">Select Question Type</option>
                    @foreach($questiontype as $question)
                      <option value="{{ $question->id }}" {{ $edit?$question->id==$model->question_type_id?'selected':'':'' }}>{{ $question->name }}</option>
                    @endforeach
                  </select>
                  <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group asdh-select">
                  <label for="difficulty_level">Country</label>
                  <select name="setquestion_id"
                          id="setquestion_id"
                          class="selectpicker"
                          data-style="select-with-transition"
                          {{--title="Select Category"--}}
                          data-live-search="true"
                          required="true"
                          data-size="5">
                    <option value="">Select Country</option>
                    <option value="nepal" {{ $edit?$question->country=='nepal'?'selected':'':'' }}>Nepal</option>
                    <option value="india" {{ $edit?$question->country=='india'?'selected':'':'' }}>India</option>
                    <option value="international" {{ $edit?$question->country=='international'?'selected':'':'' }}>International</option>
                  </select>
                  <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
                </div>
              </div>

            </div>
          @else
            {{-- question_set --}}
            <div class="form-group asdh-select">
              <label for="question_set">Question Set</label>
              <select name="question_set_id"
                      id="question_set"
                      class="selectpicker"
                      data-style="select-with-transition"
                      {{--title="Select Category"--}}
                      data-live-search="true"
                      required="true"
                      data-size="5">
                <option value="">Select Question Set</option>
                @foreach($question_sets as $question_set)
                  <option value="{{ $question_set->id }}" {{ $edit?($question_set->id==$model->question_set_id?'selected':''):($question_set->id==request()->question_set_id?'selected':'') }}>{{ $question_set->title }}</option>
                @endforeach
              </select>
              <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
            </div>
            {{-- ./question_set --}}
          @endif
        @else
          {{-- sponsors --}}
         
          <div class="form-group asdh-select">
            <label for="sponsor_id">Sponsor</label>
            <select name="sponsor_id"
                    id="sponsor_id"
                    class="selectpicker {{ $errors->has('sponsor_id')?'remove-error-message':'' }}"
                    data-style="select-with-transition"
                    {{--title="Select Category"--}}
                    data-live-search="true"
                    data-size="5">
              <option value="">Select Sponsor</option>
              @foreach($sponsors as $sponsor)
                <option value="{{ $sponsor->id }}" {{ $edit?$sponsor->id==$model->sponsor_id?'selected':'':$sponsor->id==request()->query('sponsor_id')?'selected':'' }}>
                  {{ $sponsor->name }}
                </option>
              @endforeach
            </select>
            <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
          </div>
          {{-- ./sponsors --}}
        @endif

         
        {{--question--}}
        <div class="form-group label-floating">
          <label class="control-label" for="question">{{ ucwords('question in English') }}
            <small>* (Do not add question no. here)</small>
          </label>
          <input type="text"
                 class="form-control"
                 id="question"
                 name="question"
                 required="true"
                 value="{{$edit?$model->name:old('question')}}"/>
        </div>
        <div class="form-group label-floating">
          <label class="control-label" for="question_nepali">{{ ucwords('Question in Nepali') }}
            <small>* (Do not add question no. here)</small>
          </label>
          <input type="text"
                 class="form-control"
                 id="question_nepali"
                 name="question_nepali"
                 required="true"
                 value="{{$edit?optional($model->nepali())->name:old('question_nepali')}}"/>
        </div>
        {{--./question--}}

        <div class="row">
          <div class="col-md-4">
            {{--question type--}}
            <div class="form-group">
              <label for="">Choose question type*:</label><br>
              <div class="radio question_type" style="display: inline-block;">
                <label>
                  <input type="radio"
                         name="question_type"
                         value="text" {{ $edit?($model->type=='text'?'checked="true"':null):'checked="true"' }}> Text
                </label>
              </div>
              <div class="radio question_type" style="display: inline-block;">
                <label>
                  <input type="radio"
                         name="question_type"
                         value="audio" {{ $edit?($model->type=='audio'?'checked="true"':null):null }}> Audio
                </label>
              </div>
            </div>
            {{--./question type--}}
          </div>
          <div class="col-md-8 question_file" style="display: none;">
            {{--file--}}
            <div class="form-group">
              <label for="question_file">File:</label>
              {{--<input type="file" id="question_file" name="question_file">
              <input type="text" readonly="" class="form-control" placeholder="Choose file">--}}
            </div>
            {{--./file--}}
          </div>
        </div>

        <div style="padding-top:20px;">
          <label for=""><b>Answers</b></label>

          <div class="row">
            {{--options--}}
            @if($edit)
              @foreach($model->options as $key=>$option)
                <div class="col-sm-6">
                  <div class="form-group" style="padding-left:20px;">
                    <input type="text"
                           class="form-control"
                           id="option{{$key}}"
                           name="options[{{$key}}]"
                           placeholder="Option {{$key+1}} in English*"
                           value="{{ $option->name }}"
                           required="true"/>
                  </div>
                  <div class="form-group" style="padding-left:20px;">
                    <input type="text"
                           class="form-control"
                           id="option_nepali{{$key}}"
                           name="options_nepali[{{$key}}]"
                           placeholder="Option {{$key+1}} in Nepali*"
                           value="{{ optional($option->nepali())->name }}"
                           required="true"/>
                  </div>

                  <div class="radio" style="position:absolute;left:0;top:10px;">
                    <label title="Answer">
                      <input type="radio"
                             name="answer"
                             value="{{$key}}"
                             required {{ $option->is_answer()?'checked':'' }}>
                    </label>
                  </div>
                </div>
              @endforeach
            @else
              @for($i=0;$i<4;$i++)
                <div class="col-sm-6">
                  <div class="form-group" style="padding-left:20px;">
                    <input type="text"
                           class="form-control"
                           id="option{{$i}}"
                           name="options[{{$i}}]"
                           placeholder="Option {{$i+1}} in English*"
                           required="true"/>
                  </div>
                  <div class="form-group" style="padding-left:20px;">
                    <input type="text"
                           class="form-control"
                           id="option_nepali{{$i}}"
                           name="options_nepali[{{$i}}]"
                           placeholder="Option {{$i+1}} in Nepali*"
                           required="true"/>
                  </div>

                  <div class="radio" style="position:absolute;left:0;top:10px;">
                    <label title="Answer">
                      <input type="radio" name="answer" value="{{$i}}" required>
                    </label>
                  </div>
                </div>
              @endfor
            @endif
            {{--./options--}}
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
    var $questionFile = $('.question_file');

    @if($edit && $model->type=='audio')
    hide_or_show_file('audio');
    @endif

    $(document).ready(function () {
      $('.radio.question_type').on('change', function () {
        hide_or_show_file($(this).find('input').val());
      });
    });

    function hide_or_show_file(inputVal) {
      if (inputVal !== 'text') {
        var html = '<input type="file" id="question_file" name="question_file"><input type="text" readonly="" class="form-control" placeholder="Choose file" value="{{$edit?(!is_null($model->getOriginal('file'))?$model->file:null):null}}">';
        $questionFile.children('.form-group').append(html);
        $questionFile.fadeIn();
      } else {
        $questionFile.children('.form-group').children('input').remove();
        $questionFile.fadeOut();
      }
    }
  </script>
@endpush