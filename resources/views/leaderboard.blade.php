@include('layouts.header')

<style>
  .table-img {
    border-radius       : 50%;
    background-size     : cover;
    background-repeat   : no-repeat;
    background-position : 50% 50%;
    height              : 60px;
    width               : 60px;
  }

  .rank {
    margin      : 0;
    line-height : 60px;
    color       : #22addc;
  }

  .table-dtl {
    color : #565656;
  }

  .bld {
    color : #222;
  }

  .table-dtl .name-dtl {
    font-weight   : 700;
    margin-bottom : 2px;
  }

  .table-dtl .points {
    margin-bottom : 2px;
  }

  .flag {
    height     : 30px;
    margin-top : 8px;
  }

  #btn-ldr {
    width : 540px;
  }

  #carousel {
    /*        height: 400px;*/
  }

  .banner {
    height : 292px;
  }

  /* loader box */
  .loader-box {
    position : absolute;
    top      : 0;
    bottom   : 0;
    left     : 0;
    right    : 0;
    padding  : 5%;
  }

  .loader {
    position : relative;
    margin   : 0 auto;
    width    : 100px;
  }

  .loader:before {
    content     : '';
    display     : block;
    padding-top : 100%;
  }

  .circular {
    -webkit-animation        : rotate 2s linear infinite;
    animation                : rotate 2s linear infinite;
    height                   : 100%;
    -webkit-transform-origin : center center;
    transform-origin         : center center;
    width                    : 50%;
    position                 : absolute;
    top                      : 5px;
    bottom                   : 0;
    left                     : 0;
    right                    : 0;
    margin                   : auto;
  }

  .path {
    stroke-dasharray  : 1, 200;
    stroke-dashoffset : 0;
    -webkit-animation : dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
    animation         : dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
    stroke-linecap    : round;
  }

  @-webkit-keyframes rotate {
    100% {
      -webkit-transform : rotate(360deg);
      transform         : rotate(360deg);
    }
  }

  @keyframes rotate {
    100% {
      -webkit-transform : rotate(360deg);
      transform         : rotate(360deg);
    }
  }

  @-webkit-keyframes dash {
    0% {
      stroke-dasharray  : 1, 200;
      stroke-dashoffset : 0;
    }
    50% {
      stroke-dasharray  : 89, 200;
      stroke-dashoffset : -35px;
    }
    100% {
      stroke-dasharray  : 89, 200;
      stroke-dashoffset : -124px;
    }
  }

  @keyframes dash {
    0% {
      stroke-dasharray  : 1, 200;
      stroke-dashoffset : 0;
    }
    50% {
      stroke-dasharray  : 89, 200;
      stroke-dashoffset : -35px;
    }
    100% {
      stroke-dasharray  : 89, 200;
      stroke-dashoffset : -124px;
    }
  }

  @-webkit-keyframes color {
    100%,
    0% {
      stroke : #d62d20;
    }
    40% {
      stroke : #0057e7;
    }
    66% {
      stroke : #008744;
    }
    80%,
    90% {
      stroke : #ffa700;
    }
  }

  @keyframes color {
    100%,
    0% {
      stroke : #d62d20;
    }
    40% {
      stroke : #0057e7;
    }
    66% {
      stroke : #008744;
    }
    80%,
    90% {
      stroke : #ffa700;
    }
  }

</style>

@include('extras.frontend_message')

<div id="leaderboard">
  <section class="banner">
    <div class="container">
      <div class="row">
        <div class="brandee">
          <div class="col-md-12 text-center">
            <div class="brand">
              <a href="/" class="navbar-brand"><img src="{{ frontend_url('assets/img/logo.png') }}"></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="sprite">
      <img src="{{ frontend_url('assets/img/firefly.png') }}">
    </div>
    <div class="strip" style="bottom:100px;">
      <img src="{{ frontend_url('assets/img/mark.png') }}">
    </div>
    <div class="strip">
      <img src="{{ frontend_url('assets/img/sep.png') }}" style="width: 100%;">
    </div>
    <!--     <div class="rax">
            <img src="assets/img/hamal.png">
        </div> -->
    <!--     <div class="rax1 animated wow fadeInUp" data-wow-duration="2s" data-wow-delay=".1s">
            <img src="assets/img/ios.png">
        </div> -->
    <!--     <div class="rax2 animated wow fadeInUp" data-wow-duration="2s" data-wow-delay=".3s">
            <img src="assets/img/android.png">
        </div> -->

    <div class="phone-buttons">
      <div class="btn btn-android" id="btn-ldr" style="text-align: left;">
        <a href="#" style="width: 270px;display: inline-block;"><b>This Week's Leaderboard (Top 50)</b></a>
        <a href="#" class="text-right" style="display: inline-block;width: 230px;" @click.prevent="getDataOnClickEvent">
          <i class="fa fa-refresh" :class="{'fa-pulse': gettingDataOnClick}"></i>
        </a>
      </div>
    </div>
  </section>

  <section class="leader-board">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3" style="min-height: 200px;">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Rank</th>
              <th>Picture</th>
              <th>Details</th>
              {{--<th>Country</th>--}}
            </tr>
            </thead>
            <tbody>
            <tr v-if="loading">
              <td colspan="4">
                <div class="loader-box">
                  <div class="loader">
                    <svg class="circular" viewBox="25 25 50 50">
                      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                    </svg>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-for="leaderboardIndividual,index in thisWeekLeaderboard">
              <td>
                <p class="rank"><b>@{{ index+1 }}</b></p>
              </td>
              <td>
                <div class="table-img" :style="'background-image:url(' + leaderboardIndividual.user_image + ')'">
                </div>
              </td>
              <td>
                <div class="table-dtl">
                  <p class="name-dtl">
                    @{{ leaderboardIndividual.user_name }}
                  </p>
                  <p class="points">
                    <b class="bld">@{{ leaderboardIndividual.point }}</b> points from
                    <b class="bld">@{{ leaderboardIndividual.count }}</b> game play
                  </p>
                </div>
              </td>
              {{--<td><img class="flag" src="{{ asset('public/images/neapal-flag.png') }}"></td>--}}
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
<script>
  var leaderboard = new Vue({
    el      : '#leaderboard',
    data    : {
      leaderboard       : '',
      loading           : false,
      gettingDataOnClick: false
    },
    methods : {
      getData            : function () {
        axios.get('{{ route('leaderboard.second') }}')
            .then(function (response) {
              this.leaderboard = response.data.data;
              this.loading     = false;
            }.bind(this));
      },
      getDataOnClickEvent: function () {
        this.gettingDataOnClick = true;
        setTimeout(function () {
          this.getData();
          this.gettingDataOnClick = false;
        }.bind(this), 1000);
      }
    },
    mounted : function () {
      this.loading = true;
      this.getData();
      /*setInterval(function () {
        this.getData();
      }.bind(this), 60 * 1000);*/
    },
    computed: {
      thisWeekLeaderboard: function () {
        return this.leaderboard.this_week;
      }
    }
  });
</script>

@include('layouts.footer')