<!--   Core JS Files   -->
<script src="{{material_dashboard_url('js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{material_dashboard_url('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{material_dashboard_url('js/material.min.js')}}" type="text/javascript"></script>
<script src="{{material_dashboard_url('js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<!-- Library for adding dinamically elements -->
<script src="{{material_dashboard_url('js/arrive.min.js')}}" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{material_dashboard_url('js/jquery.validate.min.js')}}"></script>
<!-- Promise Library for SweetAlert2 working on IE -->
<script src="{{material_dashboard_url('js/es6-promise-auto.min.js')}}"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{material_dashboard_url('js/moment.min.js')}}"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{material_dashboard_url('js/jquery.bootstrap-wizard.js')}}"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="{{material_dashboard_url('js/bootstrap-notify.js')}}"></script>
<!--   Sharrre Library    -->
<script src="{{material_dashboard_url('js/jquery.sharrre.js')}}"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{material_dashboard_url('js/bootstrap-datetimepicker.js')}}"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
{{--<script src="{{material_dashboard_url('js/jquery-jvectormap.js')}}"></script>--}}
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="{{material_dashboard_url('js/nouislider.min.js')}}"></script>
<!--  Google Maps Plugin    -->
{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9BUxRkJS9Aauz1ceIXn6-R5MLFRFhydM"></script>--}}
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{material_dashboard_url('js/jquery.select-bootstrap.js')}}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{material_dashboard_url('js/jquery.datatables.js')}}"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="{{material_dashboard_url('js/sweetalert2.js')}}"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{material_dashboard_url('js/jasny-bootstrap.min.js')}}"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{material_dashboard_url('js/fullcalendar.min.js')}}"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{{material_dashboard_url('js/jquery.tagsinput.js')}}"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{material_dashboard_url('js/material-dashboard.js?v=1.2.0')}}"></script>

<!-- My javascript -->
<script src="{{asset("public/js/common.js")}}"></script>
<script src="{{asset("public/js/asdh_admin.js")}}"></script>
<script>
  /*
* first parameter: the string that need to made slug
* second parameter: the input field id where slug is to be pasted
* */
  function makeSlug(stringBeforeMakingSlug, $elementToPutSlug) {
    $.ajax({
      type: 'post',
      url: @php echo '"'.route('ajax.make-slug').'"' @endphp,
      data: {'string': stringBeforeMakingSlug},
      success: function (data) {
        if (data.status) {
          $elementToPutSlug.val(data.slug);
        } else {
          alert(data.messages);
          $elementToPutSlug.val('');
        }
      },
      error: function (data) {
        console.log('Error: ', data);
      }
    });
  }
</script>
@stack('script')
