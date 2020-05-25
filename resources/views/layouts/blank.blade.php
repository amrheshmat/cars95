<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Meta -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- title -->
      <title>{{ config('app.name', 'TripleVision') }} | {{ app()->getLocale() }}</title>
    <!-- Styles -->
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{ asset('/plugins/font-awesome/css/font-awesome.min.css') }}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="{{ asset('/plugins/Ionicons/css/ionicons.min.css') }}">
      <!-- DataTables -->
      <link rel="stylesheet" href="{{ asset('/plugins/datatable/css/dataTables.bootstrap.min.css') }}">


      <!-- Daterange picker -->
      <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
      <!-- bootstrap datepicker -->
      <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

      <!-- bootstrap bootstrap-datetimepicker -->
      <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">


      <!-- iCheck for checkboxes and radio inputs -->
      <link rel="stylesheet" href="{{ asset('/plugins/iCheck/all.css') }}">
      <!-- Bootstrap Color Picker -->
      <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
      <!-- Bootstrap time Picker -->
      <link rel="stylesheet" href="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.css') }}">
      <!-- Select2 -->
      <link rel="stylesheet" href="{{asset('/plugins/select2/dist/css/select2.min.css')}}">
      <!-- fullcalendar style -->
      <link rel="stylesheet" href="{{ asset('/plugins/fullcalendar/dist/fullcalendar.min.css') }}" >
      <link rel="stylesheet" href="{{ asset('/plugins/fullcalendar/dist/fullcalendar.print.min.css') }}"  media="print">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('/css/adminlte/AdminLTE.min.css') }}">
      <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="{{ asset('/css/adminlte/skins/_all-skins.min.css') }}">
      <!-- Morris chart -->
      <link rel="stylesheet" href="{{ asset('/plugins/morris.js/morris.css') }}">
      <!-- jvectormap -->
      <link rel="stylesheet" href="{{ asset('/plugins/jvectormap/jquery-jvectormap.css') }}">
      <!-- bootstrap wysihtml5 - text editor -->
      <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
      <!-- fineuploader.com -->
      <link rel="stylesheet" href="{{ asset('/plugins/fine-uploader/fine-uploader-new.min.css') }}">
      <!-- jquery-confirm -->
      <link rel="stylesheet" href="{{ asset('/plugins/jquery-confirm-master/jquery-confirm.min.css') }}">
      <!-- bootstraptoggle  -->
      <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css') }}">
      
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <!-- JS -->
      <!-- jQuery 3 -->
      <script src="{{ asset('/plugins/jquery/dist/jquery.min.js') }}"></script>
      <!-- validate 2.2.0 -->
      <script src="{{ asset('/plugins/validate/jquery.validate.js') }}"></script>
      <!-- fineuploader.com -->
      <script src="{{ asset('/plugins/fine-uploader/all.fine-uploader.min.js') }}"></script>
      <!-- Sweetalert -->
      <!-- <script src="{{asset('/plugins/sweetalert/src/sweetalert.js')}}"></script> -->
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <!-- bootstraptoggle  -->
      <script src="{{ asset('/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js') }}"></script>
      <!-- Chart.js/2.7.1 -->
      <script src="{{ asset('/plugins/chartjs/Chart.js') }}"></script>

      <link rel="stylesheet" href="{{ asset('/plugins/dropzone/dropzone.css') }}">
      <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
	<body>

	    @yield('content')

<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="{{ asset('/plugins/jquery/dist/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })</script>
<!-- DataTables -->
<script src="{{ asset('/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatable/js/dataTables.bootstrap.min.js') }}"></script>


<!-- Select2 -->
<script src="{{ asset('/plugins/select2/dist/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('/plugins/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>


<!-- bootstrap bootstrap-datetimepicker -->
<script src="{{ asset('/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('/plugins/iCheck/icheck.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/plugins/fastclick/lib/fastclick.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('/plugins/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('/plugins/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('/plugins/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/adminlte/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('/js/adminlte/pages/dashboard.js') }}"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ asset('js/adminlte/demo.js') }}"></script>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
<!-- jquery-confirm -->
<script src="{{ asset('/plugins/jquery-confirm-master/jquery-confirm.min.js') }}"></script>
<!-- fullcalendar -->
<script src="{{asset('/plugins/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{ asset('/plugins/dropzone/dropzone.js') }}"></script>


</body>
</html>