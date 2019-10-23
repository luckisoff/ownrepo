@extends('admin.layouts.app')

@section('title', 'Top banner advertisement management')

@push('css')
  <style>
    .asdh-edit {display : none;}
  </style>`
@endpush

@section('content')

  <div class="row">
    <div class="col-md-4">
      <form action="{{$edit?route($routeType.'.update',[$model, 'category' => request()->query('category')]):route($routeType.'.store',['category' => request()->query('category')])}}"
            method="post"
            enctype="multipart/form-data"
            class="from-prevent-multiple-submit"
            id="TypeValidation">
        {{csrf_field()}}
        {{$edit?method_field('PUT'):''}}
        <div class="card">

          <div class="card-header card-header-text" data-background-color="green">
            <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }}
              <b>{{ categoryName(request()->query('category')) }}</b></h4>
          </div>

          <div class="card-content">

            <div class="row">
              <div class="col-md-12">
                {{-- image --}}
                @if($edit)
                  @include('extras.input_image', ['input_image'=>$model->image(200,200), 'image_name_field'=>'image'])
                @else
                  @include('extras.input_image')
                @endif

                {{-- url --}}
                <div class="form-group label-floating">
                  <label class="control-label" for="url">Url</label>
                  <input type="url"
                         class="form-control"
                         id="url"
                         name="url"
                         value="{{$edit?$model->url:old('url')}}"/>
                </div>
                {{-- ./url --}}

                @if(request()->query('category')==4)
                  <input type="hidden" name="type" value="top">
                  <input type="hidden" name="active" value="1">
                @else
                  <div class="row">
                    <div class="col-md-6">
                      {{-- type --}}
                      <div class="radio">
                        <label>
                          <input type="radio"
                                 name="type"
                                 value="full"
                                 required="true" {{ $edit?($model->type=='full'?'checked':''):'' }}> Full
                        </label>
                        <label>
                          <input type="radio"
                                 name="type"
                                 value="top"
                                 required="true" {{ $edit?($model->type=='top'?'checked':''):'' }}> Top
                        </label>
                      </div>
                      {{-- ./type --}}
                    </div>
                    <div class="col-md-6 text-right">
                      {{-- active --}}
                      {{--<div class="checkbox" style="margin-top: 10px;">
                        <label>
                          <input type="checkbox" name="active" value="1" {{ $edit?($model->active?'checked':''):'' }}>
                          Active
                        </label>
                      </div>--}}
                      {{-- ./active --}}
                    </div>
                  </div>
                @endif

                {{-- submit --}}
                <div class="text-right">
                  <button type="submit"
                          class="btn btn-success btn-fill btn-prevent-multiple-submit">{{ $edit?'Update':'Save' }}</button>
                </div>
                {{-- ./submit --}}
              </div>
            </div>

          </div>

        </div>
      </form>
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="card-header card-header-text" data-background-color="green">
          <h4 class="card-title">All <b>{{ str_plural(ucwords(categoryName(request()->query('category')))) }}</b></h4>
        </div>
        <a href="{{ route($routeType.'.create', ['category'=>request()->query('category')]) }}"
           class="btn btn-success btn-round btn-xs create-new">
          <i class="material-icons">add_circle_outline</i> New {{ categoryName(request()->query('category')) }}
        </a>

        <div class="card-content">
          <div class="table-responsive">
            <table class="table">
              <thead>
              <tr>
                <th width="40">#</th>
                <th>Image</th>
                <th>Url</th>
                @if(request()->query('category')!=4)
                  <th>Active</th>
                  <th>Type</th>
                @endif
                <th width="80">Actions</th>
              </tr>
              </thead>
              <tbody>
              @forelse($models->sortBy('type') as $key=>$model)
                <tr>
                  <td>{{$key+1}}</td>
                  <td width="60"><img src="{{$model->image(50,50)}}" alt="{{$model->name}}"></td>
                  <td><a href="{{$model->url}}" target="_blank">{{$model->url}}</a></td>
                  @if(request()->query('category')!=4)
                    <td>
                      {{--ad_active--}}
                      <div class="form-group">
                        <div class="radio">
                          <label>
                            <input
                                class="advertisement-make-active"
                                type="radio"
                                name="ad_active_{{ $model->type }}"
                                data-url="{{ route('ajax.advertisement.make-active', $model) }}"
                                {{ $model->active?'checked':null }}>
                          </label>
                        </div>
                      </div>
                    </td>
                    <td>{{ $model->type }}</td>
                  @endif
                  <td class="asdh-edit_and_delete td-actions">
                    <a href="{{ route($routeType.'.edit', [$model, 'category' => request()->query('category')]) }}"
                       type="button"
                       class="btn btn-success"
                       title="Edit">
                      <i class="material-icons">edit</i>
                    </a>
                    @include('extras.edit_delete', ['modal'=>$model, 'message'=>'You will not be able to recover your data in the future.'])
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4">No data available</td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      $('.advertisement-make-active').on('change', function () {
        var $this = $(this);

        $.ajax({
          type   : 'post',
          url    : $this.data('url'),
          success: function (data) {
            showAlertMessageSuccess(data.message);
            console.log(data.message);
          },
          error  : function (data) {
            console.log('Error: ', data);
          }
        })
      });
    });
  </script>
@endpush