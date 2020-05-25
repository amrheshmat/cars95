@extends('layouts.app')
@section('content')

@role('superadmin|medical|syndicate.admin')
<div class="row">
  <div class="col-xl-4 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="info">{{$medical['pending']}}</h3>
                      <h6>المطالبات الطبية المعلقة</h6>
                    </div>
                    <div>
                      <i class="fa fa-stethoscope info font-large-2 float-right"></i>
                      <i class="fa fa-hourglass-start info "></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
  </div>
  <div class="col-xl-4 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="success">{{$medical['accepted']}}</h3>
                      <h6>المطالبات الطبية المقبولة</h6>
                    </div>
                    <div>
                      <i class="fa fa-stethoscope success font-large-2 float-right"></i>
                      <i class="fa fa-check-circle success "></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
  </div>
  <div class="col-xl-4 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="red">{{$medical['refused']}}</h3>
                      <h6>المطالبات الطبية المرفوضة</h6>
                    </div>
                    <div>
                      <i class="fa fa-stethoscope red font-large-2 float-right"></i>
                      <i class="fa fa-times red "></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-red" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
  </div>
</div>

<section class="row">

            <div class="col-xl-6 col-lg-12 col-md-12">
              <div class="card" style="">
                <div class="card-head">
                  <div class="card-header">
                    <h4 class="card-title">نسبة المطالبات الطبية</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-content">
                    <div id="task-pie-chart" class="height-400 echart-container"></div>
                </div>
              </div>
            </div>


            <div class="col-xl-3 ">
            <div class="card pull-up">
                  <div class="card-header bg-hexagons">
                    <h4 class="card-title">الأكثر طلبا هذا الشهر
                    </h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="card-content collapse show bg-hexagons">
                    <div class="card-body pt-0">
                      @foreach($medicalProviders_counts as $provider)
                           <span class="badge badge-success badge-pill float-right">{{$provider->requests}}</span> <a href="#" class="black"> {{$provider->name}}</a>
                           <hr>
                      @endforeach
                   
                  
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-xl-3 ">
            <div class="card pull-up">
                  <div class="card-content collapse show bg-gradient-directional-danger ">
                    <div class="card-body bg-hexagons-danger">
                      <h4 class="card-title white">مطالبات طبية متأخرة (5ساعات )
                       
                      </h4>
                      <div class="chartjs"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                      @foreach($medical_requests_latest as $request)
                         <span class="badge badge-warning  badge-pill float-right" style="color:white"> من  ({{$request['hours']}}) ساعة </span> <a href="{{url('/MedicalRequest')}}/{{$request['id']}}/edit" style="color:white"> {{$request['name']}}</a>
                         <hr>
                     @endforeach
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <!--/ Task Progress -->
            <!-- Bug Progress -->
           

           
            <!--/ Bug Progress -->
          </section>




          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
                  <h4>اداء الموظفين</h4>
                    <div class="row">
                      @foreach($medicalActions_users as $user)
                      <div class="col-xl-4 col-lg-6 col-12">
                        <div class="card">
                          <div class="card-content">
                            <div class="media align-items-stretch">
                              <div class="p-2 bg-success text-white media-body text-left rounded-left">
                                <h5 class="text-white">{{$user->name}}</h5>
                                <h5 class="text-white text-bold-400 mb-0">{{$user->requests}} موافقة طبية </h5>
                              </div>
                              <div class="p-2 text-center bg-success bg-darken-2 rounded-right">
                                <span><img src="{{url('/')}}{{$user->picture}}" alt="avatar" style="width:70px;"><i></i></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      <!-- sssssssssssssss -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endrole


  <script>
    
$(window).on("load", function(){


require.config({
    paths: {
        echarts: '../../../app-assets/vendors/js/charts/echarts'
    }
});

require(
    [
        'echarts',
        'echarts/chart/pie',
        'echarts/chart/funnel'
    ],


    function (ec) {
        var myChart = ec.init(document.getElementById('task-pie-chart'));

        chartOptions = {

            
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },

            legend: {
                orient: 'horizontal',
                x: 'left',
                data: [ 'مقبول' , 'مرفوض']
            },

            color: ['#168dee', '#1ec481','#d32f2f'],

            toolbox: {
                show: true,
                orient: 'horizontal',
                
            },

            // Enable drag recalculate
            calculable: true,

            // Add series
            series: [{
                name: '',
                type: 'pie',
                radius: '70%',
                center: ['{{$medical["accepted_percentage"]}}%','{{$medical["refused_percentage"]}}%'],
                data: [
                    {value: {{$medical["accepted"]}}, name: 'مقبول'},
                    {value: {{$medical["refused"]}}, name: 'مرفوض'},
                ]
            }]
        };

        // Apply options
        // ------------------------------

        myChart.setOption(chartOptions);


        // Resize chart
        // ------------------------------

        $(function () {

            // Resize chart on menu width change and window resize
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);

            // Resize function
            function resize() {
                setTimeout(function() {

                    // Resize chart
                    myChart.resize();
                }, 20);
            }
        });
    }
);
});
 </script>
@endsection