@extends('layouts.app')
@section('content')
@if(Session::has('message'))
   <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<br/>
<div class="container-fluid" style="min-height: 900px">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="trips_requests.id">
	<input type="hidden" id="model"  	 value="tripRequest">
	<input type="hidden" id="groupby" 	 value="trips_requests.id">
	<input type="hidden" id="path" 	 	 value="{{tripRequest}}">
	<input type="hidden" id="conditions" value='{}' name="conditions">
 	@include(Admin.'.layouts.datatable')
	<!--End Index-->
</div>
@endsection
