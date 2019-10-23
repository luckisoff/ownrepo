@include('layouts.header')

@include('extras.frontend_message')

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
    <div class="rax">
        <img src="{{ frontend_url('assets/img/hamal.png') }}">
    </div>
    <div class="rax1 animated wow fadeInUp" data-wow-duration="2s" data-wow-delay=".1s">
        <img src="{{ frontend_url('assets/img/ios.png') }}">
    </div>
    <div class="rax2 animated wow fadeInUp" data-wow-duration="2s" data-wow-delay=".3s">
        <img src="{{ frontend_url('assets/img/android.png') }}">
    </div>

    <div id="carousel" class="carousel slide carousel-fade">
        <div class="container">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
            </ol>
        </div>
        <!-- Carousel items -->
        <div class="carousel-inner">
            <div class="active item">
                <div class="container">
                    <div class="carou-center">
                        <div class="center-carou">
                            <div class="col-md-12 col-sm-12 col-xs-12 no-padding text-center">
                                {{--<h1><span>YOU</span>Have Helped Others Win Now Its <span>Your Turn</span></h1>--}}
                                <div class="imager-slide">
                                    <img src="{{ asset('public/images/registration-new.png') }}" alt="earn" style="width:73%;">
                                </div>
                                <div class="imager-slide">
                                    <img src="{{ asset('public/frontend/assets/img/play.png') }}" alt="earn"  style="width:30%; margin-top:30px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="item">
              <div class="container">
                <div class="carou-center">
                  <div class="center-carou">
                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding text-center">
                      <h1><span>MILLIONAIRE</span> Helps Others To Pay The <span>Sweepskates</span></h1>
                    </div>
                  </div>
                </div>
              </div>
            </div>--}}
        </div>
        <div class="phone-buttons">
            <a class="btn btn-android" href="https://play.google.com/store/apps/details?id=com.thesunbi.kbcnepal"
               target="_blank"><i class="fa fa-ios"></i>Google Play Store</a>
            <a class="btn btn-ios" href="https://itunes.apple.com/us/app/kbc-nepal/id1347588056?mt=8&uo=4"
               target="_blank"><i class="fa fa-android"></i>App Store</a>
        </div>
        <!--        <div class="svg-vec">-->
        <!--        <!-- Generator: Adobe Illustrator 21.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
        <!--        <svg version="1.1" id="Layer_1" class="layerer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"-->
        <!--             viewBox="0 0 925 162" style="enable-background:new 0 0 925 162;" xml:space="preserve">-->
        <!--        <style type="text/css">-->
        <!--            .st0{fill:#FFCC4C;stroke:#FCDEA2;stroke-width:5.3841;stroke-miterlimit:10;}-->
        <!--        </style>-->
        <!--                    <path class="st0" d="M842.4,150.2c15.6-6.9,25.5-18.7,34-30.2c5.1-6.9,9-14.6,15.9-20.7c6.5-5.7,16-9.4,24.7-13.1-->
        <!--            c-10.4-4.6-22.9-9.7-29-17.8c-9.4-12.7-15.5-27.7-27.5-39.6c-14.9-14.7-40.2-19.8-64-19.9C775,8.9,753.5,8.8,732,8.7-->
        <!--            C664,8.4,596,8.1,528.1,7.9c-76.4-0.2-152.8-0.4-229.2-0.4c-55.5,0-111-0.1-166.6,0.6c-19.2,0.2-30.7,0.4-47.8,7.3-->
        <!--            C68.8,21.7,58,33.6,49.7,44.9c-5.1,7-9,14.7-15.9,20.9C27.3,71.6,17.7,75.3,9,79c10.4,4.6,23,9.7,29.1,17.8-->
        <!--            c8,10.7,22.4,44.5,45,52.4c15,5.2,26.1,5.8,42.1,5.8c10,0,20,0,30,0c28,0,55.9,0,83.9,0c74.6,0,149.2,0,223.8,0-->
        <!--            c74.5,0,149,0,223.5,0c44.4,0,88.8,0,133.2,0C828.2,155,835.7,153.2,842.4,150.2z"/>-->
        <!--            <text x="460px" y="85px" font-size="45px" fill="#01000a" font-weight="900"  text-anchor="middle" alignment-baseline="central">PRACTICE, LEARN AND EARN </text>-->
        <!--        </svg>-->
        <!--        </div>-->
</section>
<!--<section class="location">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-md-12">-->
<!--                <div class="all-form">-->
<!--                    <div class="col-md-6 col-sm-12 col-xs-12 text-right">-->
<!--                        <h3>Watch Millionaire<span>Weekdays</span></h3>-->
<!--                    </div>-->
<!--                    <div class="col-md-6 col-sm-12 col-xs-12">-->
<!--                        <form class="form-inline form-loc">-->
<!--                            <div class="form-group">-->
<!--                                <img src="assets/img/location.png">-->
<!--                                <div class="input-group">-->
<!--                                    <input type="text" class="form-control" placeholder="Find Your Nearest Location">-->
<!--                                    <div class="input-group-addon"><button type="submit" class="btn"><i class="fa fa-search"></i></button></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<section class="about">
    <div class="container">
        <div class="row">
            <div class="cover-about">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="cover-image-abt">
                        <div class="wrap-abt-image"
                             style="background: url('{{ frontend_url('assets/img/raj.jpg') }}'); background-size: cover; background-position: 50% 50%; width: 100%; height: 300px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <h1>About <span>Show</span></h1>
                    <p>Ko Bancha Crorepati (Who Will Be a Millionaire) is a Nepali television game show based on
                        the British Program :Who Wants to Be a Millionaire. After
                        ruling the roast all over the world, the Nepalese version
                        of the show is here to change the dynamics of TV viewing....</p>
                    <!--                    <a href="#" class="link">View Detail<i class="fa fa-long-arrow-right"></i></a>-->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="videosr videos">
    <div class="container">
        <div class="row">
            <div class="video-wrap">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <h1>Our <span>Videos</span></h1>
                </div>
                    <div class="owl-carousel owl-theme owlern" style="padding: 70px 0px 0px 0px;">
                        <div class="item">
                            <div class="wrap-item"
                                 style="background: url('{{ frontend_url('assets/img/capture.jpg') }}'); background-size: cover; background-position: 50% 50%;">
                                <div class="wrap-wrap-item">
                                    <div class="center-owl">
                                        <div class="owl-center text-center">
                                            <a href="https://www.youtube.com/watch?v=OGQ5FarAufA"
                                               target="_blank"><img src="{{ frontend_url('assets/img/play-button.png') }}"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="wrap-item"
                                 style="background: url('{{ frontend_url('assets/img/capture1.jpg') }}'); background-size: cover; background-position: 50% 50%;">
                                <div class="wrap-wrap-item">
                                    <div class="center-owl">
                                        <div class="owl-center text-center">
                                            <a href="https://www.youtube.com/watch?v=6PdXyjizlF4"
                                               target="_blank"><img src="{{ frontend_url('assets/img/play-button.png') }}"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--                <div class="col-md-12 text-center">-->
                <!--                    <button class="btn btn-md btn-view">View All</button>-->
                <!--                </div>-->
            </div>
        </div>
    </div>
</section>

<section class="contact">
    <div class="row-fluid">
        <div class="cover-all-footer col-md-6 col-sm-12 col-sm-12">
            <div class="col-md-10 col-md-offset-2">
                <div class="head-footer">
                    <h1>Send Us <span>Feedback</span></h1>
                </div>
                <form class="fomby" method="post" action="{{ route('contact-us') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <textarea rows="7" class="form-control" placeholder="Message" name="body" required>{{ old('body') }}</textarea>
                    </div>
                    <div class="form-group">
                        <script src='https://www.google.com/recaptcha/api.js'></script>
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.public') }}"></div>
                    </div>
                    <button type="submit" class="btn btn-md btn-view">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 no-padding">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d56526.859982498034!2d85.31319980424178!3d27.68859697542936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sasmita+publication!5e0!3m2!1sen!2snp!4v1518592448117"
                        width="100%"
                        height="606"
                        frameborder="0"
                        style="border:0"
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>
<section class="videos">
    <div class="container">
        <div class="row">
            <div class="video-wrap">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <h1>Our <span>Partners</span></h1>
                </div>
                <div class="col-md-12 all-own-owl">
                    <img src="{{ frontend_url('assets/img/Logos.jpg') }}" class="img-responsive" style="margin: auto; display: block;">
                    {{--<div class="content-owl">--}}
                        {{--<div class="owl-carousel owl-theme owler" style="padding: 70px 0px 0px 0px;">--}}
                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Co-sponsor">--}}
                                    {{--<img src="{{ frontend_url('assets/img/enchan.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Co-sponsor">--}}
                                    {{--<img src="{{ frontend_url('assets/img/baltra.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Banking Partner">--}}
                                    {{--<img src="{{ frontend_url('assets/img/civil.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Supported By">--}}
                                    {{--<img src="{{ frontend_url('assets/img/hero.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Technology & Digital Partner">--}}
                                    {{--<img src="{{ frontend_url('assets/img/logo1.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Ticketing Partner">--}}
                                    {{--<img src="{{ frontend_url('assets/img/khalti.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Social Media Partner">--}}
                                    {{--<img src="{{ frontend_url('assets/img/meme.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<div class="wrap-item" data-toggle="tooltip" data-placement="bottom" title="Clothing Partner">--}}
                                    {{--<img src="{{ frontend_url('assets/img/suit.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <!--                    <div class="col-md-12 text-center">-->
                <!--                        <button class="btn btn-md btn-view">View All</button>-->
                <!--                    </div>-->
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')