
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="{{url('/assets/img/favicon-16x16.png')}}" sizes="16x16">
    <title> neQabty Login</title>    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{url('/css/login.css')}}" rel="stylesheet">
    <link href="{{url('/css/custom.css')}}" id="theme" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/earlyaccess/notokufiarabic.css">
       
      
</head>
<body>   
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    
    <section id="wrapper">
        <div class="login-register" style="background-image:url({{url('/assets/img/bg_4.jpg')}});background-position: center center;">
            <div class="text-center logo"><img src="{{url('/assets/img/logo.png')}}" alt="neQabty"></div>
            
            <div class="login-box card animated flipInX card-login">
                
                <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('MerchantLogin') }}">
                     {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-xs-12">
                            <input id="email" type="text" class="form-control" name="email" placeholder="البريد الإلكترونى" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                             </div>
                        </div>


                       <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password" type="password" class="form-control" placeholder="كلمة المرور" name="password" required autocomplete > 
                            </div>
                                 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                       

                       
                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> تذكرنى </label>
                                </div> </div>
                        </div>


                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">تسجيل الدخول</button>
                            </div>
                           
                        </div>                       
                        
                    </form>
                    
                    
                   
                </div>
                <div class="card-footer" align="center">
                    <p class="text-muted m-t-0">© {{date('Y')}} neQabty V2.01</p>
                </div>
            </div>
        </div>
    </section>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://darmaiman.arabiaapi.com/js/custom.min.js"></script>
</body>

</html>