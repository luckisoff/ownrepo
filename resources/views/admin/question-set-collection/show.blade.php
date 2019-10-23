@extends('admin.layouts.app')

@section('title', "Add question sets to {$question_set_collection->title}")

@section('content')

  <form action="{{ route($routeType.'.add-question-sets', $question_set_collection) }}"
        method="post"
        class="from-prevent-multiple-submit"
        id="TypeValidation">
    {{csrf_field()}}
    <div class="card">

      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">Add question sets to <b>{{ $question_set_collection->title }}</b></h4>
      </div>

      <div class="card-content">

        <div class="row">
          @foreach($question_sets as $question_set)
            <div class="col-xs-6 col-sm-4">
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"
                           name="question_set_ids[]"
                           @if($question_set_collection->has_question_set($question_set)) checked @endif
                           value="{{ $question_set->id }}"> {{ $question_set->title }}
                  </label>
                  <a href="{{ route('question-set.show',$question_set) }}"
                     title="See questions of this set"
                     style="position:absolute;padding-left:5px;">
                    <div class="material-icons">remove_red_eye</div>
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        {{--submit--}}
        <div class="text-right" style="margin-top:30px;">
          <button type="submit"
                  class="btn btn-success btn-fill btn-prevent-multiple-submit">Add
          </button>
        </div>
        {{--./submit--}}
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