@extends('layouts.app')
@section('content')
<br/>
<div class="container-fluid" style="min-height: 900px">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="governorates.id">
	<input type="hidden" id="model"  	 value="Governorate">
	<input type="hidden" id="groupby" 	 value="governorates.id">
	<input type="hidden" id="path" 	 	 value="{{Setting}}">
	<input type="hidden" id="conditions" value='{}' name="conditions">
 	@include(Admin.'.layouts.datatable')
	<!--End Index-->
</div>
@endsection
