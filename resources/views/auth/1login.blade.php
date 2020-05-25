@extends('layouts.blank')
@section('content')
<style type="text/css">
 .login-page:before {
    content: "";
    /*background-image: url('http://www.kampyle.com/wp-content/uploads/blog-post-2-headphone.jpg');*/
    background-image: url('{{asset("/img/login.jpg")}}');
    position: fixed;
    left: 0;
    right: 0;
    top: -10px;
    z-index: -1;  
    display: block;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    width: 100%;
    height: 100%;
    /*-webkit-filter: blur(5px);
    -moz-filter: blur(5px);
    -o-filter: blur(5px);
    -ms-filter: blur(5px);
    filter: blur(5px);*/
    }

    .login-page {
      position: fixed;
      right: 0;
      z-index: 0;
      height: 100% !important;
      /*margin-left: 20px;*/
      /*margin-right: 20px;*/
    }
    .login-box{
        height: 100%;
        /*width: 320px;*/
        background-color: #fff;
        margin-top: 0;
    }
    .login-box-body, .register-box-body{
        background-color: #fff;
    }
    .login-logo, .register-logo{
        padding-top: 30%;
    }
    .login-logo a{
        color: #68417C;
    }
</style>
<body class=" login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b><img src='{{asset("/img/icon.png")}}' width="200px" height="80px"> </b><p></p></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <!-- <p class="login-box-msg">Sign in to start your session </p> -->

            <form class="" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    <input name="username"  type="text" class="form-control" placeholder="Email" value="{{ old('username') }}" required autofocus>
                        
                    </span>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <input name="password" type="password" class="form-control" placeholder="Password" required>
                    </span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <span> Remember Me </span>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                      <button type="submit" class="btn bg-primary btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
            <a href="{{ route('password.request') }}" class="text-primary">I forgot my password</a><br>
            <div class="row">
                <div class="container">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <span class="help-block">
                            <strong class="description-percentage text-red">{{ $error }}</strong>
                            </span>      
                        @endforeach
                    @endif
                    
                   
                </div>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
</div>
   
</body>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue',
      increaseArea: '20%' // optional
    });
  });

</script>
@endsection
