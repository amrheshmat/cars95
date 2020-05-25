<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta name="description" content="{{ config('app.description', 'Neqabty') }}">
      <meta name="keywords" content="{{ config('app.keyword') }}">
      <meta name="author" content="{{ config('app.author', 'Neqabty') }}">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Neqabty') }} | {{ app()->getLocale() }}</title>
      <link rel="apple-touch-icon" href="{{ url(config('app.iconpng', 'Neqabty')) }}">
      <link rel="shortcut icon" type="image/x-icon" href="{{ url(config('app.icon', 'Neqabty')) }}">

      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
      <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

      <!-- BEGIN VENDOR CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/vendors.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/forms/selects/select2.min.css') }}">
      <!-- END VENDOR CSS-->
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{ asset('/plugins/font-awesome/css/font-awesome.min.css') }}">
      <!-- END Font Awesome -->
      <!-- BEGIN MODERN CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/app.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/custom-rtl.css') }}">
      <!-- END MODERN CSS-->
      <!-- BEGIN Page Level CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/core/colors/palette-gradient.css') }}">      
      <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/cryptocoins/cryptocoins.css') }}">
      <!-- END Page Level CSS-->

      <!-- BEGIN jquery-confirm -->
      <link rel="stylesheet" href="{{ asset('/plugins/jquery-confirm-master/jquery-confirm.min.css') }}">
      <!-- END jquery-confirm -->

      
      <!-- BEGIN Custom CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style-rtl.css') }}">
      <link href="{{asset('/css/custom.css')}}" id="theme" rel="stylesheet">     
      <!-- END Custom CSS--> 
      <script src="{{asset('/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
      <!-- BEGIN validate 2.2.0 -->
      <script src="{{ asset('/plugins/validate/jquery.validate.js') }}"></script>
      <!-- END validate 2.2.0 -->
      














<!-- bootstrap bootstrap-datetimepicker -->
<link rel="stylesheet" href="{{ asset('/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">





      
<!-- daterangepicker -->
<script src="{{ asset('/plugins/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>


<!-- bootstrap bootstrap-datetimepicker -->
<script src="{{ asset('/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

    </head>
    <body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns"> 
   
      <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
        <div class="navbar-wrapper">
          <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
              <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
              <li class="nav-item"> <a class="navbar-brand" href="{!! url('/') !!}"> <img class="brand-logo" alt="{!! config('app.name', 'Neqabty') !!} logo" src="{{ url(config('app.logo', 'Neqabty')) }}"> <h3 class="brand-text"> @lang('neqabty.'.config('app.name')) </h3> </a> </li>
              <li class="nav-item d-md-none">
                <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
              </li>
            </ul>
          </div>
          <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
              <ul class="nav navbar-nav mr-auto float-left">
                <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
              </ul>
                
              <ul class="nav navbar-nav float-right">
                <li class="dropdown dropdown-user nav-item">
                    @if(Auth::user()!==null)
                  <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                    <span class="mr-1"> {{isset( Auth::user()->roles()->first()->name ) ?  Auth::user()->roles()->first()->name  : ""}} - <span class="user-name text-bold-700">{{isset(Auth::user()->name) ? Auth::user()->name : ""}}</span></span>
                    <span class="avatar avatar-online"><img src="{{ asset(Auth::user()->picture) }}" alt="avatar"><i></i></span>
                  </a>
                    @else
                     <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                    <span class="mr-1"><span class="user-name text-bold-700">{{Auth::guard('merchant')}}</span></span>
                  </a>
                @endif
                  <div class="dropdown-menu dropdown-menu-right">
                    {{-- <div class="dropdown-divider"></div> --}}
                    {!! Form::model('logout',['method'=>'POST','route'=>'logout']) !!} <button class="dropdown-item" type="submit"><i class="ft-power"></i> Logout</button>{!! Form::close() !!}
                  </div>
                </li>
                <li class="dropdown dropdown-language nav-item">
                  <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-eg"></i><span class="selected-language"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right " aria-labelledby="dropdown-flag">
                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-gb"></i> English</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      {{-- <aside id="sidebar_main"  algin="right"> --}}
        @include('layouts.sidebar')
      {{-- </aside> --}}

      <div class="app-content content" algin="right">
        <div class="content-wrapper">
          {{-- Header --}}
          <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
              <h3 class="content-header-title"> @lang('neqabty.'.config('app.name', 'Neqabty'))</h3>
              <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('Dashboard')}}"><i class="fa fa-dashboard"></i> @lang('neqabty.dashboard')</a></li>
                    <?php $sublink ='';?>
                    @for($i=0;$i< 10;$i++)
                        @if(!empty(Request::segment($i)) and Request::segment($i) !='Dashboard' )
                        <?php $sublink .=Request::segment($i).'/';?>  
                          @if (\Lang::has('neqabty.'.Request::segment($i)))                      
                            <li class="breadcrumb-item"><a href="{{url('/'.$sublink)}}"> @lang('neqabty.'.Request::segment($i)) </a></li>
                            @else
                              {{-- <li class="breadcrumb-item"><a href="{{url('/'.$sublink)}}"> {{Request::segment($i)}} </a></li> --}}
                          @endif
                        @endif
                    @endfor                    
                  </ol>
                </div>
              </div>
            </div>
          </div>
          {{-- End Header --}}
          <div class="content-body">
