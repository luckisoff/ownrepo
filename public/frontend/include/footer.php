<section class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <a href="#" class="brand"><img src="assets/img/logoftr.png"></a>
        <p>Ko Bancha Crorepati (Who Will Be a Millionaire) is a Nepali television game show based
          on the British Program :Who Wants to Be a Millionaire. After ruling the roast all over the world,
          the Nepalese version of the show is here to change the dynamics of TV viewing</p>
        <ul class="list-social-icon">
          <li><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
          <li><a href="#"><i class="fa fa-google"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="last-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-12 col-xs-12">
        <p class="dsgnr">Copyright &copy; 2018 . <a href="index.php">KBCNEPAL</a> . All Rights Reserved</p>
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12 text-center">
        <ul class="list-link">
          <li><a href="http://kbcnepal.com/tou">Terms Of Use</a></li>
          <li><a href="http://kbcnepal.com/privacy-policy">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12 text-right">
        <p class="dsgnr">design: <a href="http://www.thesunbi.com" target="_blank">SunBi</a></p>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript" src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.carousel').carousel({
      interval: 8000
    });
  });
</script>
<script>
  $(window).scroll(function () {
    if ($(document).scrollTop() > 50) {
      $('.navbar-all-custom').addClass('opaque');
    } else {
      $('.navbar-all-custom').removeClass('opaque');
    }
  });
</script>
<script>
  $(document).ready(function () {
    $('.owler').owlCarousel({
      loop           : false,
      margin         : 10,
      nav            : false,
      autoplayTimeout: 10000,
      autoplay       : false,
      margin         : 40,
      navText        : ['<img src="assets/img/prev.png">', '<img src="assets/img/next.png">'],
      smartSpeed     : 3000,
      dots           : false,
      responsive     : {
        0   : {
          items: 1
        },
        600 : {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
    $('.owlern').owlCarousel({
      loop           : false,
      margin         : 10,
      nav            : false,
      autoplayTimeout: 10000,
      autoplay       : false,
      margin         : 0,
      navText        : ['<img src="assets/img/prev.png">', '<img src="assets/img/next.png">'],
      smartSpeed     : 3000,
      dots           : false,
      responsive     : {
        0   : {
          items: 1
        },
        600 : {
          items: 2
        },
        1000: {
          items: 2
        }
      }
    });

  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<script src="assets/js/wow.min.js"></script>
<script>
  new WOW().init();
</script>
</body>
</html>