<footer class="section footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="widget clearfix">
                            <div class="newsletter-widget">
                                <p>You can opt out of our newsletters at any time.<br> See our <a href="#">privacy policy</a>.</p>
                                <form class="form-inline" role="search">
                                    <div class="form-1">
                                        <input type="text" class="form-control" placeholder="Enter email here..">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i></button>
                                    </div>
                                </form>
                            </div><!-- end newsletter -->
                        </div><!-- end widget -->
                    </div><!-- end col -->

                    <div class="col-lg-2 col-md-4">
                        <div class="widget clearfix">
                            <div class="list-widget">   
                                <ul>
                                    <li><a href="{{url('ReadMore')}}">About us</a></li>
                                    <li><a href="page-about-me.html">About me</a></li>
                                    <li><a href="page-services.html">Our Services</a></li>
                                    <li><a href="page-team.html">Our Team</a></li>
                                    <li><a href="page-contact-01.html">Contact us</a></li>
                                </ul>
                            </div><!-- end list-widget -->
                        </div><!-- end widget -->
                    </div><!-- end col -->

                    <div class="col-lg-2 col-md-4">
                        <div class="widget clearfix">
                            <div class="list-widget">   
                                <ul>
                                    <li><a href="page-contact-02.html">Get In Touch</a></li>
                                    <li><a href="page-faqs.html">FAQ's</a></li>
                                    <li><a href="page-testimonials.html">Testimonials</a></li>
                                    <li><a href="page-elements-html">Elements</a></li>
                                    <li><a href="page-404.html">Not Found</a></li>
                                </ul>
                            </div><!-- end list-widget -->
                        </div><!-- end widget -->
                    </div><!-- end col -->

                    <div class="col-lg-2 col-md-4">
                        <div class="widget clearfix">
                            <div class="list-widget">   
                                <ul>
                                    <li><a href="shop-checkout.html">Checkout</a></li>
                                    <li><a href="shop-cart.html">Shopping Cart</a></li>
                                    <li><a href="shop-account.html">My Account</a></li>
                                    <li><a href="shop-login.html">Login / Register</a></li>
                                </ul>
                            </div><!-- end list-widget -->
                        </div><!-- end widget -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </footer><!-- end footer -->

        <div class="section copyrights" style="padding:7px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="cop-logo">
                            <img src="images/logo.png"  width="50px;"  alt="">
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 text-right">
                        <div class="cop-links">
                            <ul class="list-inline">
                                <li>&copy; 2020 AMRHESHMAT | Design: <a href="https://html.design"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end wrapper -->

    <!-- jQuery Files -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/carousel.js') }}"></script>
    <script src="{{ asset('/js/parallax.js') }}"></script>
    <script src="{{ asset('/js/rotate.js') }}"></script>
    <script src="{{ asset('/js/custom.js') }}"></script>
    <script src="{{ asset('/js/masonry.js') }}"></script>
    <script src="{{ asset('/js/masonry-4-col.js') }}"></script>
    <!-- VIDEO BG PLUGINS -->
    <script src="videos/libs/swfobject.js"></script> 
    <script src="videos/libs/modernizr.video.js"></script> 
    <script src="videos/libs/video_background.js"></script> 
    <script>
        jQuery(document).ready(function($) {
            var Video_back = new video_background($("#home"), { 
                "position": "absolute", //Follow page scroll
                "z-index": "-1",        //Behind everything
                "loop": true,           //Loop when it reaches the end
                "autoplay": true,       //Autoplay at start
                "muted": true,          //Muted at start
                "mp4":"videos/video.mp4" ,     //Path to video mp4 format
                "video_ratio": 1.7778,              // width/height -> If none provided sizing of the video is set to adjust
                "fallback_image": "images/dummy.png",   //Fallback image path
                "priority": "html5"             //Priority for html5 (if set to flash and tested locally will give a flash security error)
            });
        });
    </script>

</body>
</html>