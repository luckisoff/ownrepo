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
        <h4 class="card-title">{{ $edit?'Edit':'Add a New ' }} {{ ucfirst($routeType) }}</h4>
      </div>

      <div class="card-content">

        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-12">
                {{--week_day--}}
                <div class="form-group">
                  <label for="week_day">{{ ucwords('week day') }}
                    <small>*</small>
                  </label>
                  <input type="number"
                         class="form-control"
                         id="week_day"
                         name="week_day"
                         required="true"
                         value="{{$edit?$model->week_day:old('week_day')}}"/>
                </div>
                {{--./week_day--}}
              </div>

              <div class="col-sm-12">
                <div class="row" v-for="(sponsorIndividual) in sponsorCount" :id="'removeSponsor'+sponsorIndividual">
                  <div class="col-sm-3">
                    {{-- sponsor --}}
                    <div class="form-group asdh-select">
                      <label :for="getCurrentSponsorId(sponsorIndividual)">Sponsor
                        @if(!$edit)
                          <a href="#"
                             v-if="sponsorIndividual===1"
                             class="label label-info"
                             @click.prevent="addMoreSponsors">add</a>
                          <a href="#"
                             v-if="sponsorIndividual>1"
                             class="label label-danger"
                             :data-id="'removeSponsor'+sponsorIndividual"
                             @click.prevent="removeSponsor('#removeSponsor'+sponsorIndividual)">remove</a>
                        @endif
                      </label>
                      <select :id="getCurrentSponsorId(sponsorIndividual)"
                              class="selectpicker show-tick"
                              name="{{ $edit?'sponsor_id':'sponsor_ids[]' }}"
                              required
                              @change="getPrizesOfSponsor"
                              data-style="select-with-transition">
                        <option value="">Select Sponsor</option>
                        @foreach($sponsors as $sponsor)
                          <option value="{{ $sponsor->id }}" {{ $edit?$model->sponsor_id==$sponsor->id?'selected':'':'' }}>
                            {{ $sponsor->name }}
                          </option>
                        @endforeach
                      </select>
                      <div class="material-icons select-drop-down-arrow">keyboard_arrow_down</div>
                    </div>
                    {{-- ./sponsor --}}
                  </div>

                  <div class="col-sm-9">
                    {{--prizes--}}
                    <div class="form-group">
                      <label :for="getCurrentPrizeId(sponsorIndividual)">{{ ucwords('prize') }}
                        <small>*</small>
                      </label>
                      <textarea class="form-control asdh-tinymce basic"
                                name="{{ $edit?'prize':'prizes[]' }}"
                                :id="getCurrentPrizeId(sponsorIndividual)"
                                cols="30"
                                rows="3">{{ $edit?$model->description:'' }}</textarea>
                    </div>
                    {{--./prizes--}}
                  </div>
                </div> <!-- end v-if -->
              </div>
            </div>

            {{--submit--}}
            <div class="text-right">
              <button type="submit"
                      class="btn btn-success btn-fill btn-prevent-multiple-submit">{{ $edit?'Update':'Save' }}</button>
            </div>
          </div>
        </div>

      </div>

    </div>
  </form>
@endsection

@push('script')
  @include('extras.tinymce')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

  <script>
    var vueInstance = new Vue({
      el     : '#TypeValidation',
      created: function () {

      },
      data   : {
        sponsorId   : '',
        sponsorCount: 1,
        sponsors    : [],
        prizes      : {}
      },
      methods: {
        getPrizesOfSponsor : function (event) {
          /*var sponsorId = event.target.value;
          if (sponsorId === '') {
            this.prizes = {};
            return;
          }
          axios.get('/admin/get-prizes-of-sponsor/' + sponsorId)
              .then(function (response) {
                this.prizes = response.data.prizes;
              }.bind(this));*/
        },
        addMoreSponsors    : function () {
          ++this.sponsorCount;
          // this.sponsors.push(this.sponsorCount);
          this.refreshSelectOption();
          setTimeout(function () {
            tinymceSimpleInit();
          },100);
        },
        refreshSelectOption: function () {
          $(document).ready(function () {
            $('.selectpicker').selectpicker('refresh');
          });
        },
        getCurrentSponsorId: function (sponsorIndividual) {
          return sponsorIndividual === 1 ? 'sponsorId' : 'sponsorId' + sponsorIndividual;
        },
        removeSponsor      : function (sponsorIndividual) {
          $(document).ready(function () {
            $(sponsorIndividual).remove();
          });
        },
        getCurrentPrizeId  : function (prizeIndividual) {
          return prizeIndividual === 1 ? 'prizeId' : 'prizeId' + prizeIndividual;
        }
      }
    });
  </script>
@endpush