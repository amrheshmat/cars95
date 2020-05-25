@extends('layouts.app')
@section('content')
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="info-box bg-blue">
          <span class="info-box-icon"><i class="ion-ios-telephone"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">@lang('crm.totalCalls')</span>
           <span class="info-box-number">55555555555555</span>z
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
            <span class="progress-description">  @lang('crm.inThisMonth') </span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>
     
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-7 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="nav-tabs-custom">
          <!-- Tabs within a box -->
          <ul class="nav nav-tabs pull-right">
            <li class="active"><a href="#revenue-chart" data-toggle="tab">Calls</a></li>
            <li class="pull-left header"><i class="fa fa-phone"></i> Call performance </li>
          </ul>
          <div class="tab-content no-padding">
            <!-- Morris chart - Sales -->
            <canvas id="chartCall" width="400" height="150"></canvas>
          </div>
        </div>
        <!-- /.nav-tabs-custom -->
        <!-- quick email widget -->

      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-5 connectedSortable">
        <div class="box box-info">
          <div class="box-header">
            <i class="fa fa-envelope"></i>

            <h3 class="box-title">Quick Email</h3>
            <!-- tools box -->
            <div class="pull-right box-tools">
            </div>
            <!-- /. tools -->
          </div>
              <div class="box-body">
                
              </div>
              <div class="box-footer clearfix">
                <button data-form="SendMail" class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
              </div>
              <div class="overlay"  id="loadmail" style="display: none;"><i class="fa fa-refresh fa-spin"></i></div>
        </div>
        <!-- /.box -->
      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->
  </section> 
  <script src="{{ asset('/js/adminlte/pages/dashboard.js') }}"></script>
  <script type="text/javascript">
    // $(document).ajaxStart(function() { Pace.restart(); }); 
    



    var ctx= document.getElementById("chartCall");
   // var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "My First dataset",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 30, 45],
        }]
    },

    // Configuration options go here
    options: {}
});
  </script>
@endsection
  