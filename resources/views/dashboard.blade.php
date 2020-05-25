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
              <span class="info-box-number">{{ $customers->sum('countperday') }}</span>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description"> {{ $customers->sum('countpermonth') }} @lang('crm.inThisMonth') </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
        @foreach( $customers as $customer)
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="info-box {{{ $customer->color  or 'bg-red'}}}">
              <span class="info-box-icon"><i class="{{{ $customer->icon  or 'ion-ios-trash'}}}"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">{{{ $customer->name  or 'error'}}}<span>
                <span class="info-box-number">{{{ $customer->countperday or 'error' }}}</span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description"> {{{ $customer->countpermonth or 'error' }}}  @lang('crm.inThisMonth') </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
        @endforeach 
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
                  {!! Form::open(['route' => ['SendMail'] ,'id'=> 'SendMail','method'=>'POST','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
                    <div class="form-group">
                      <select class="form-control select2" id="emailto" name="emailto" placeholder="Email to:">
                        @foreach (App\User::pluck('email','email')->toArray() as $email)
                        <option> {{$email}}  </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="subject" placeholder="Subject">
                    </div>
                    <div>
                      <textarea class="textarea" name="message" placeholder="Message"
                                style="width: 100%; height: 225px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                  {!! Form::close()!!}
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
    $(document).ready(function(){  
      $('#emailto').select2();  
      $( "#sendEmail" ).on( "click", function( event ) {
        event.preventDefault();
        $('#loadmail').fadeOut(800, function() { $(this).show(); });
        $('#sendEmail').fadeOut(1, function() { $(this).hide(); });
        var form = $('#'+$(this).data('form'));
        var formAction = form.attr('action');
        var dataString =form.serialize();
        $.ajax({
          type: "POST",
          url : formAction,
          data : dataString,
          success : function(data){
            $('#sendEmail').fadeOut(800, function() { $(this).show(); });
            $('#loadmail').fadeOut(1, function() { $(this).hide(); });
            $.alert({
              type: 'green',
              title :data.title, 
              autoClose: 'ok|300',
              content:data.message,
              icon: 'fa fa-send-o',
              theme: 'modern',
              closeIcon: true,
              animation: 'scale',
              
            });
          },
          error: function(data){
            // Error...
             $.alert({
              type: 'red',
              title :'Error', 
              content:'Could you try again later',
              icon: 'fa fa-remove',
              theme: 'modern',
              closeIcon: true,
              animation: 'scale',
              
            });
            $('#sendEmail').fadeOut(800, function() { $(this).show(); });
            $('#loadmail').fadeOut(1, function() { $(this).hide(); });
            var errors = $.parseJSON(data.responseText);
            $( "#error" ).empty();
            $( "#error" ).append('<div class="alert alert-danger" id="inserterror">');
            $.each(errors, function(index, value) {
                $( "#inserterror" ).append(value + '<br/>' );                   
            });
          }
        },"json");
      });
    });
    var customerss    = '{{$chart}}';
    var customers     = JSON.parse(customerss.replace(/&quot;/g,'"'));  
    var labelx        = customers.map(function(a) {return a.createdat;});
    var result1       = customers.map(function(a) {return a.total;});
    var cb            = customers.map(function(a) {return a.cb;});
    var verification  = customers.map(function(a) {return a.verification;});
    var deleted       = customers.map(function(a) {return a.deleted;});
    var pieChartCanvas= document.getElementById("chartCall");
    var scatterChart  = new Chart(pieChartCanvas, {
      // type: 'line',
      type: 'bar',
      // type: 'horizontalBar',
      data: { 
        labels: labelx,
        datasets: [
          
          {
            label: "CB",
            backgroundColor: 'rgba(0, 166, 90, 0.6)',
            borderColor    : 'rgba(0, 166, 90, 1)',
            data: cb,
          },
          {
            label: "Sent fro Verification",
            backgroundColor: 'rgba(243, 156, 18, 0.6)',
            borderColor    : 'rgba(243, 156, 18, 1)',
            data: verification,
          },
          {
            label: "Deleted",
            backgroundColor: 'rgba(221, 75, 57, 0.6)',
            borderColor    : 'rgba(221, 75, 57, 1)',
            data: deleted,
          },
        ]
      }
    });
  </script>
@endsection
