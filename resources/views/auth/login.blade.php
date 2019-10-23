<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Login</title>
  <!-- Favicon-->
  <link rel="icon" href="{{asset(admin_url_material('favicon.ico'))}}" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext"
        rel="stylesheet"
        type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

  <!-- Bootstrap Core Css -->
  <link href="{{admin_url_material('plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="{{admin_url_material('plugins/node-waves/waves.css')}}" rel="stylesheet"/>

  <!-- Animation Css -->
  <link href="{{admin_url_material('plugins/animate-css/animate.css')}}" rel="stylesheet"/>

  <!-- Custom Css -->
  <link href="{{admin_url_material('css/style.min.css')}}" rel="stylesheet">
</head>

<body class="login-page">
<div class="login-box">
  <div class="card">

    @if(count($errors))
      <div class="alert alert-danger alert-dismissible" role="alert">{{$errors->first()}}</div>
    @endif
    @if(session("success_message"))
      <div class="alert alert-success alert-dismissible" role="alert">{{session("success_message")}}</div>
    @endif

    <div class="body">
      <form id="sign_in" role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="msg">Login</div>
        <div class="input-group">
          <span class="input-group-addon">
              <i class="material-icons">email</i>
          </span>
          <div class="form-line">
            <input type="email"
                   class="form-control"
                   name="email"
                   placeholder="Email"
                   required
                   autofocus
                   value="{{'ashish@gmail.com'??old('email')}}">
          </div>
        </div>
        <div class="input-group">
          <span class="input-group-addon">
              <i class="material-icons">lock</i>
          </span>
          <div class="form-line">
            <input type="password" class="form-control" name="password" placeholder="Password" value="kkkkkk" required>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-8 p-t-5">
            <input type="checkbox"
                   name="remember"
                   id="rememberme"
                   class="filled-in chk-col-pink" {{ old('remember') ? 'checked' : '' }}>
            <label for="rememberme">Remember Me</label>
          </div>
          <div class="col-xs-4">
            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
          </div>
        </div>
        {{--facebook login--}}
        {{--<div class="p-t-5" style="background:#3b5998;padding:10px;text-align:center;">
          <a href="{{route('facebookLogin')}}" style="color:#ffffff;">Login with Facebook</a>
        </div>--}}
        {{--google login--}}
        {{--<div style="background:#db4437;padding:10px;text-align:center;margin-top:5px;">
          <a href="{{route('googleLogin')}}" style="color:#ffffff;">Login with Google</a>
        </div>--}}
        {{--<div class="row m-t-15 m-b--20">
          <div class="col-xs-12 text-center">
            <a href="{{route('register')}}">Don't have an account. Create from here.</a>
          </div>
          <div class="col-xs-6 align-right">
            <a href="#">Forgot Password?</a>
          </div>
        </div>--}}
      </form>
    </div>
  </div>
</div>

<!-- Jquery Core Js -->
<script src="{{admin_url_material('plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{admin_url_material('plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{admin_url_material('plugins/node-waves/waves.js')}}"></script>

<!-- Validation Plugin Js -->
<script src="{{admin_url_material('plugins/jquery-validation/jquery.validate.js')}}"></script>

<!-- Custom Js -->
<script src="{{admin_url_material('js/admin.js')}}"></script>
<script src="{{admin_url_material('js/pages/examples/sign-in.js')}}"></script>
</body>

</html>