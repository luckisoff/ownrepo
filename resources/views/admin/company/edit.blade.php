@extends('admin.layouts.app')

@section('title', 'Company Information')

@section('content')

  <form role="form"
        action="{{route('company.update', $company->id)}}"
        method="post"
        enctype="multipart/form-data"
        id="form_validation">
    {{csrf_field()}}
    {{method_field('PUT')}}

    <div class="card">
      <div class="card-header card-header-text" data-background-color="green">
        <h4 class="card-title">Edit Company Information</h4>
      </div>

      <div class="card-content">

        <div class="row">
          <div class="col-md-2">
            {{--logo--}}
            @include('extras.input_image', ['input_image'=>$company->image(140,140,'logo'), 'image_name_field'=>'logo'])
          </div>
          <div class="col-md-10">
            {{--name--}}
            <div class="form-group label-floating">
              <label class="control-label" for="name">
                Company Name
                <small>*</small>
              </label>
              <input type="text"
                     class="form-control"
                     id="name"
                     name="name"
                     required="true"
                     value="{{ $company->getOriginal('name') }}"/>
            </div>
            {{--./name--}}

            <div class="row">
              <div class="col-md-6">
                {{--email--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="email">
                    Email
                    <small>*</small>
                  </label>
                  <input type="email"
                         class="form-control"
                         id="email"
                         name="email"
                         required="true"
                         email="true"
                         value="{{$company->email}}"/>
                </div>
                {{--./email--}}
              </div>

              <div class="col-md-6">
                {{--phone--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="phone">
                    Phone
                  </label>
                  <input type="text"
                         class="form-control"
                         id="phone"
                         name="phone"
                         number="true"
                         value="{{$company->phone}}"/>
                </div>
                {{--./phone--}}
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                {{--established date--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="established_date">
                    Established Date
                    <small>*</small>
                  </label>
                  <input type="text"
                         class="form-control datepicker"
                         id="established_date"
                         name="established_date"
                         value="{{$company->established_date->format('m/d/Y')}}"/>
                </div>
                {{--./established date--}}
              </div>

              <div class="col-md-6">
                {{--address--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="address">
                    Address
                  </label>
                  <input type="text"
                         class="form-control"
                         id="address"
                         name="address"
                         value="{{$company->getOriginal('address')}}"/>
                </div>
                {{--./address--}}
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                {{--facebook_url--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="facebook_url">Facebook Url</label>
                  <input type="url"
                         class="form-control"
                         id="facebook_url"
                         name="facebook_url"
                         url="true"
                         value="{{$company->facebook_url}}"/>
                </div>
                {{--./facebook_url--}}
              </div>
              <div class="col-md-6">
                {{--twitter_url--}}
                <div class="form-group label-floating">
                  <label class="control-label" for="twitter_url">Twitter Url</label>
                  <input type="url"
                         class="form-control"
                         id="twitter_url"
                         name="twitter_url"
                         url="true"
                         value="{{$company->twitter_url}}"/>
                </div>
                {{--./twitter_url--}}
              </div>
            </div>

            {{--about--}}
            <div class="form-group">
              <label class="control-label" for="about">About</label>
              <textarea class="form-control asdh-tinymce"
                        id="about"
                        name="about"
                        rows="10">{{$company->about}}</textarea>
            </div>
            {{--./about--}}

            {{--reg_terms_of_use--}}
            <div class="form-group">
              <label for="reg_terms_of_use">{{ ucwords('registration terms of use') }}</label>
              <textarea class="form-control asdh-tinymce"
                        id="reg_terms_of_use"
                        name="reg_terms_of_use"
                        rows="10">{{ $company->reg_terms_of_use }}</textarea>
            </div>
            {{--./reg_terms_of_use--}}

            {{--terms_of_use--}}
            <div class="form-group">
              <label for="terms_of_use">{{ ucwords('terms of use') }}</label>
              <textarea class="form-control asdh-tinymce"
                        id="terms_of_use"
                        name="terms_of_use"
                        rows="10">{{ $company->terms_of_use }}</textarea>
            </div>
            {{--./terms_of_use--}}

            {{--privacy_policy--}}
            <div class="form-group">
              <label for="privacy_policy">{{ ucwords('privacy policy') }}</label>
              <textarea class="form-control asdh-tinymce"
                        id="privacy_policy"
                        name="privacy_policy"
                        rows="10">{{ $company->privacy_policy }}</textarea>
            </div>
            {{--./privacy_policy--}}
          </div>
        </div>

        {{--submit--}}
        <div class="form-footer text-right">
          <button type="submit" class="btn btn-success btn-fill">Update</button>
        </div>

      </div>
    </div>
  </form>
@endsection

@push('script')
  @include('extras.tinymce')
  <script type="text/javascript">
    $(document).ready(function () {
      $('.datepicker').datetimepicker({
        format: 'MM/DD/YYYY',
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down",
          previous: 'fa fa-chevron-left',
          next: 'fa fa-chevron-right',
          today: 'fa fa-screenshot',
          clear: 'fa fa-trash',
          close: 'fa fa-remove'
        }
      });
    });
  </script>
@endpush