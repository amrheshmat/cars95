
<!doctype html>
<!--[if IE 9]> <html class="no-js ie9 fixed-layout" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js " lang="en"> <!--<![endif]-->
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Site Meta -->
    <title>Cars</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

	<!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet"> 

	<!-- Custom & Default Styles -->
    




	<!--[if lt IE 9]>
		<script src="js/vendor/html5shiv.min.js"></script>
		<script src="js/vendor/respond.min.js"></script>
	<![endif]-->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">    

</head>
<body class="left-menu">  
    
    <div class="menu-wrapper">
        <div class="mobile-menu">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{url('/home')}}" width=120px; style="color:#FFF"><img style='display: inline;' src="images/logo.png" width="40px;" alt=""> Amr Heshmat </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="{{url('/home')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Home</a>
                            </li>
                            <li class="dropdown">
                                <a href="{{url('Homenews')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> News </span></a> 
                            </li>
                            <li class="dropdown">
                                <a href="{{url('/newCars')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">New Cars</a>
                            </li>
                            <li class="dropdown">
                                <a href="{{url('/usedCars')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Used Cars</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Our Services <span class="fa fa-angle-down"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Service centers</a></li>
                                    <li><a href="#">tires </a></li>
                                    <li><a href="#">spare parts </a></li>
                                    <li><a href="#">Repair centers  </a></li>
                                </ul>
                            </li>
                            <li><a href="{{url('/contact')}}">Contact</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
        </div><!-- end mobile-menu -->

        <header class="vertical-header">
            <div class="vertical-header-wrapper">
                <nav class="nav-menu">
                    <div class="logo">
                        <a href="{{url('/home')}}"><img src="images/logo.png" width="50px;" alt=""><br> Amr Heshmat</a>
                    </div><!-- end logo -->

                    <div class="margin-block2"></div>

                    <ul class="primary-menu">
                        <li class="child-menu"><a href="{{url('/home')}}">Home</a>
                        </li>
                        <li class="child-menu"><a href="{{url('Homenews')}}">News  </a>
                        </li>
                        <li class="child-menu"><a href="{{url('/newCars')}}">New Cars </a>
                            
                        </li>
                        <li class="child-menu"><a href="{{url('/usedCars')}}" >Used Cars </a>
                            
                        </li>
                        <li class="child-menu"><a href="#">Our Services <i class="fa fa-angle-right"></i></a>
                            <div class="sub-menu-wrapper">
                                <ul class="sub-menu center-content">
                                    <li><a href="#">Service centers</a></li>
                                    <li><a href="#">tires</a></li>
                                    <li><a href="#">spare parts </a></li>
                                    <li><a href="#">Repair centers  </a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{url('/contact')}}">Contact</a></li>
                    </ul>
                    
                    <div class="margin-block"></div>

                    <div class="menu-search">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="What you are looking?">
                                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div><!-- end menu-search -->

                    <div class="margin-block"></div>

                    <div class="menu-social">
                        <ul class="list-inline text-center">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div><!-- end menu -->
                </nav><!-- end nav-menu -->
            </div><!-- end vertical-header-wrapper -->
        </header><!-- end header -->
    </div><!-- end menu-wrapper -->
    <div id="wrapper">

<!--@section('content')-->
<div id="home" class="video-section js-height-full">
    <div class="overlay"></div>
    <div class="home-text-wrapper relative container">
        <div class="home-message">
            <img src="images/biglogo.png" width="100px;" alt="">
            <p>Twenty Thirty Builders</p>
            <div class="btn-wrapper">
                <div class="text-center">
                    <a href="{{url('ReadMore')}}" class="btn btn-primary">Read More</a> &nbsp;<a href="#" class="btn btn-default">Buy Now</a>
                </div>
            </div><!-- end row -->
        </div>
    </div>
</div>

<div class="section bgcolor noover">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tagline-message">
                    <h3><mark class="rotate">Hello, Bonjour, Merhaba</mark> we are Twenty Thirty Builders, we have brought together the best quality services, offers, projects for you!</h3>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->