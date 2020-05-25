</div>
        </div>    
    </div>
    <a id="back-to-top" href="#" class="btn btn-info btn-sm back-to-top" role="button" title="Click to return on the top page"  data-placement="bottom"><i class="la la-angle-double-up"></i></a>
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a class="text-bold-800 grey darken-2" href="#"
            target="_blank">{{ config('app.name', 'Neqabty') }} </a>, All rights reserved. </span>
            <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"> A-B-C-D-E <i class="ft-heart pink"></i></span>
        </p>
    </footer>
    <style>
        .back-to-top {cursor: pointer;position: fixed;bottom: 50px;display:none;margin-right: 94%;opacity: 1;}
    </style>

  
    
    <!-- google web fonts -->
    {{-- <script src="{{asset('/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script> --}}
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('/app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('/app-assets/vendors/js/charts/chart.min.js')}}"       type="text/javascript"></script>
    <script src="{{asset('/app-assets/vendors/js/charts/echarts/echarts.js')}}" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    
    <!-- jquery-confirm -->
    <script src="{{ asset('/plugins/jquery-confirm-master/jquery-confirm.min.js') }}"></script>
    <!-- END jquery-confirm -->
    <!-- BEGIN MODERN JS-->
    <script src="{{asset('/app-assets/js/core/app-menu.js')}}"      type="text/javascript"></script>
    <script src="{{asset('/app-assets/js/core/app.js')}}"           type="text/javascript"></script>
    <script src="{{asset('/app-assets/js/scripts/customizer.js')}}" type="text/javascript"></script>
    <!-- END MODERN JS-->


    






    <!-- BEGIN PAGE LEVEL JS-->
    {{-- <script src="{{asset('/app-assets/js/scripts/pages/dashboard-crypto.js')}}" type="text/javascript"></script> --}}
    
    
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>
    {{-- <script>
        $(function() {
            if(isHighDensity()) {
                $.getScript( "assets/js/custom/dense.min.js", function(data) {
                    altair_helpers.retina_images();
                });
            }
            if(Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            altair_helpers.ie_fix();
        var t =  $('.col-status_name').html();
        if (t.indexOf('رفض') >= 0){
            $(this).parent().css('background-color','#f1b8cf');
        }else if(t.indexOf('قبول') >= 0){
            $(this).parent().css('background-color','#80ecbb');
        }
              

        });
    </script> --}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','http://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-65191727-1', 'auto');
        ga('send', 'pageview');
    </script>
    <script>
        $(document).ready(function(){
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
        
            // scroll body to 0px on click
            $('#back-to-top').click(function () {
                $('#back-to-top').hide();
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
           
            // $('#back-to-top').show();
            $('.col-status_name').each(function() {
        var t =  $(this).html();
        if (t.indexOf('رفض') >= 0){
            $(this).parent().css('background-color','#f1b8cf');
        }else if(t.indexOf('قبول') >= 0){
            $(this).parent().css('background-color','#80ecbb');
        }
              

        });

        //col-status_name

      
        
    });
    </script>
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{asset('/app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->




</body>
</html>