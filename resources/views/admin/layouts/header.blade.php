<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="viewport" content="width=device-width"/>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap core CSS -->
<link href="{{material_dashboard_url('css/bootstrap.min.css')}}" rel="stylesheet"/>
<!-- Material Dashboard CSS -->
<link href="{{material_dashboard_url('css/material-dashboard.css?v=1.2.0')}}" rel="stylesheet"/>
<!-- Fonts and icons -->
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet"
      type="text/css"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Favicon-->
{{--<link rel="icon" href="{{ $company->image(50,50,'logo') }}">--}}
<link rel="icon" href="{{ $company->logo }}">
<title>@yield('title') - {{ $company->name }} Admin</title>

<!-- My css -->
<link href="{{asset("public/css/asdh_admin.css")}}" rel="stylesheet">
@stack('css')