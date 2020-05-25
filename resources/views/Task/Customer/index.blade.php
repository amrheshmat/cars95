@extends('layouts.app')
@section('content')
<div class="container-fluid" style="min-height: 900px">
  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <div class="tab-content">
        	<!--Index-->
              <table id="UnVerifiedCustomer" class="table table-hover table-bordered table-striped">
                <!-- <table id="UnVerifiedCustomer" class="table table-bordered table-striped"> -->
               	<thead>
                    <tr style="background-color: #3c8dbc;color: #fff;">
        	            <th>#</th>
        	            <th>Customer Name</th>
        	            <th>email</th>
        	            <th>id_verified</th>
        	            <th>phone_no</th>
        	            <th>ph_verified</th>
        	            <th>group</th>
        	            <th>is_verified</th>
        	            <th>created</th>
        	            <th>takeAction</th>
                	</tr>
                </thead>
                <tbody>
                   	@foreach($datatable as $td)
                   	<tr>
                			<td class="time-label"><a href="{{Route('Customer.show',$td->id)}}" data-col="col-md-5 col-md-push-4" data-id="{{$td->id}}" class="tableShowItems" style="text-decoration: underline;"> {{$td->id}}</a></td>
                			<td class="time-label"> {{$td->firstname.' '.$td->lastname}}</td>
                			<td class="time-label"> {{$td->email}}</td>
                			<td class="time-label"> {{$td->id_verified}}</td>
                			<td class="time-label"> {{$td->phone_no}}</td>
                			<td class="time-label"> {{$td->ph_verified}}</td>
                			<td class="time-label"> {{$td->group}}</td>
                			<td class="time-label"> {{$td->is_verified}}</td>
                			<td class="time-label"> {{date("d-M-y H:i:s", strtotime($td->created))}} </td>
                			<td class="time-label"><center><a href="{{Route('Customer.edit',$td->id)}}" data-id="{{$td->id}}" type="button" class="tableEditItems  btn btn-primary btn-xs"><i class=" fa fa-pencil"></i></a></center></td>
                 	  </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr style="background-color: #3c8dbc;color: #fff;">
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>email</th>
                    <th>id_verified</th>
                    <th>phone_no</th>
                    <th>ph_verified</th>
                    <th>group</th>
                    <th>is_verified</th>
                    <th>created</th>
                    <th>takeAction</th>
                  </tr>
                </tfoot>
          	 </table>
        	<!--End Index-->
        </div>
      </div>
    </div>
  </div>
</div>

	<script>
		//DataTable
	  	$(function () {$('#UnVerifiedCustomer').DataTable()});
	  	$(document).on('click','.tableShowItems',function(e) {
  			// body...
  			e.preventDefault();
  			var link = $(this).attr('href');
  			var id   = $(this).data('id');
  			var ajax   = $(this).data('ajax');
  			var col   = $(this).data('col');
  			$.dialog({
  				columnClass: col,
  				title  : '#'+id, 
	  			content: 'URL:'+link+'?ajax='+ajax,
	  		});
  		});
  		
</script>
@endsection
