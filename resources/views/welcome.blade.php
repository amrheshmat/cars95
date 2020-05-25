@extends('carslayouts.app')

@section('content')

        <section class="section lb nopadtop noover">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="service-box m30">
                            <i class="flaticon-monitor"></i>
                            <h3>Outstanding design</h3>
                            <p>Designed to be flexible according to all your needs. Create your site with all module position.</p>
                        </div>
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12">
                        <div class="service-box m30">
                            <i class="flaticon-technology"></i>
                            <h3>Responsive Layout</h3>
                            <p>Genius template can be easily viewed on any mobile device. Smoothly responsive.</p>
                        </div>
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12">
                        <div class="service-box m30">
                            <i class="flaticon-gears"></i>
                            <h3>Easy to use</h3>
                            <p>The modules we have prepared are simple to use. No code information is needed.</p>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end section -->

        <section class="section lb">
            <div class="container">
                <div class="section-title text-center">
                    <h3>Latest News</h3>
                    <p>Maecenas sit amet tristique turpis. Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. Donec consectetur accumsan arcu.</p>
                </div><!-- end title -->

                <div class="container">
            @foreach($news as $new)
                <div class="col-lg-4 col-md-12" style="overflow: hidden;height: 600px;margin-bottom:40px;">
                    <div class="blog-box" style="height: 85%;">
                        <div class="post-media">
                            <a href="#"><img src="images{{$new->img}}" alt="" class="img-responsive"></a>
                        </div><!-- end media -->
                        <div class="blog-desc">
                            <h4><a href="#"> {{$new->title}}</a></h4>
                            <p>
                            {{$strcut = substr($new->desc,0,250)}} 
                            {{ $strcut }}</p>
                        </div><!-- end blog-desc -->

                        <div class="post-meta">
                            <ul class="list-inline">
                                <li><a href="#">{{$new->created_at}}</a></li>
                            </ul>
                        </div><!-- end post-meta -->
                    </div><!-- end blog -->
                </div><!-- end col -->
                @endforeach
                
            </div>
           
        </section>  

        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12">
                        <div class="text-widget">
                            <h3>Powerful template features</h3>

                            <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla nunc dui, tristique in <a href="#">semper vel</a>, congue sed ligula. Nam dolor ligula, faucibus id sodales in, auctor fringill torquent per conubia nostra.</p>

                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 first">
                                    <ul class="check">
                                        <li>Custom Shortcodes</li>
                                        <li>Visual Page Builder</li>
                                        <li>Unlimited Shortcodes</li>
                                        <li>Responsive Theme</li>
                                        <li>Tons of Layouts</li>
                                    </ul><!-- end check -->
                                </div><!-- end col-lg-4 -->
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <ul class="check">
                                        <li>Font Awesome Icons</li>
                                        <li>Pre-Defined Colors</li>
                                        <li>AJAX Transitions</li>
                                        <li>High Quality Support</li>
                                        <li>Unlimited Options</li>
                                    </ul><!-- end check -->    
                                </div><!-- end col-lg-4 -->
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 last">
                                    <ul class="check">
                                        <li>Shopping Layouts</li>
                                        <li>Pre-Defined Fonts</li>
                                        <li>Style Changers</li>
                                        <li>Footer Styles</li>
                                        <li>Header Styles</li>
                                    </ul><!-- end check -->
                                </div><!-- end col-lg-4 --> 
                            </div><!-- end row -->      
                        </div><!-- end widget -->
                    </div><!-- end col-lg-6 -->
                </div><!-- end row -->
            </div><!-- end container -->
            <div class="perspective-image hidden-sm hidden-xs hidden-md"> 
                <img src="images/upload/p1.jpg" alt="" class="img-responsive">
            </div>
        </section>

        <section class="section lb">
            <div class="container">
                <div class="section-title text-center">
                    <h3>New Cars </h3>
                    <p>Maecenas sit amet tristique turpis. Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. Donec consectetur accumsan arcu, sit amet fringilla ex ultricies.</p>
                </div><!-- end title -->

                <div class="case-top clearfix">
                    <div class="pull-left hidden-xs">
                        <p>Showing 1–12 of 24 results</p>
                    </div><!-- end col -->

                    <div class="pull-right">
                        <div class="dropdown portfolio-filter">
                            <button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown">Product Filter
                            <span class="fa fa-angle-down"></span></button>
                            <ul class="dropdown-menu">
                              <li><a class="active" href="#" data-filter="*">All Projects</a></li>
                            @foreach($cars as $car)
                                <li><a class="" href="#" data-filter=".{{$car->car_type}}">{{$car->car_type}}</a></li>
                            @endforeach
                            </ul>
                        </div><!-- end dropdown -->
                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="portfolio row with-desc">
                        @foreach($cars as $car)
                            <div class="post-media pitem item-w1 item-h1 {{$car->car_type}}">
                                <div class="entry">
                                    <img src="{{$car->car_img}}" alt="" class="img-responsive">
                                    
                                </div><!-- end entry -->
                                
                                <div class="item-desc">
                                    <h4><a href="#">{{$car->car_name}}</a></h4>
                                    <p>{{$car->car_desc}}</p>
                                    <div style="margin-left: 25%;">
                                <a style="border-radius:10px;width: 60px;text-align: center;padding: 9px;" class=" btn btn-primary" href="{{url('buyItem/').'/'.$car->id}}">
                                    Buy
                                    </a>
                                    <a style="border-radius:10px;width: 60px;text-align: center;padding: 9px;" class=" btn btn-primary" href="{{url('viewItem/').'/'.$car->id}}">
                                    View
                                    </a>
                                 </div>
                                </div>
                                
                            </div><!-- end post-media -->
                     
                        @endforeach
                        </div><!-- end row -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end section -->


        <section class="section">
            <div class="container">
                <div class="section-title text-center">
                    <h3>Case Studies</h3>
                    <p>Maecenas sit amet tristique turpis. Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. Donec consectetur accumsan arcu, sit amet fringilla ex ultricies.</p>
                </div><!-- end title -->

                <div id="owl-01" class="owl-carousel owl-theme owl-theme-01">
                    <div class="item">
                        <img src="images/upload/work_03.jpg" alt="" class="img-responsive">
                        <div class="magnifier">
                            <div class="magni-desc">
                                <h4>
                                    <a href="#">Website Template</a>
                                    <small>in: websites</small>
                                </h4>
                                <a class="goitem" href="#"><i class="fa fa-link"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <img src="images/upload/work_04.jpg" alt="" class="img-responsive">
                        <div class="magnifier">
                            <div class="magni-desc">
                                <h4>
                                    <a href="#">CSS3 Animation</a>
                                    <small>in: animations</small>
                                </h4>
                                <a class="goitem" href="#"><i class="fa fa-link"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <img src="images/upload/work_01.jpg" alt="" class="img-responsive">
                        <div class="magnifier">
                            <div class="magni-desc">
                                <h4>
                                    <a href="#">Mockup Template</a>
                                    <small>in: mockups</small>
                                </h4>
                                <a class="goitem" href="#"><i class="fa fa-link"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <img src="images/upload/work_02.jpg" alt="" class="img-responsive">
                        <div class="magnifier">
                            <div class="magni-desc">
                                <h4>
                                    <a href="#">Mockup Template</a>
                                    <small>in: css3</small>
                                </h4>
                                <a class="goitem" href="#"><i class="fa fa-link"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end container -->
        </section>


        <section class="section bgcolor">
            <div class="container">
                <a href="#">
                <div class="row callout">
                    <div class="col-md-4 text-center">
                        <h3><sup>$</sup>49.99</h3>
                        <h4>Start your awesome project today!</h4>
                    </div><!-- end col -->

                    <div class="col-md-8">
                        <p class="lead">Limited time offer! Your Agency profile will be added to our "Agencies" directory as well. </p>
                    </div>
                </div><!-- end row -->
                </a>
            </div><!-- end container -->  
        </section>
        @endsection
      