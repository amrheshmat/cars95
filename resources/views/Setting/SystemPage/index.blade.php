@extends('layouts.app')
@section('content')
<br/>
<div class="container-fluid" style="min-height: 900px">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="id">
	<input type="hidden" id="model"  	 value="SystemPage">
	<input type="hidden" id="groupby" 	 value="id">
	<input type="hidden" id="path" 	 	 value="{{Setting}}">
	<input type="hidden" id="conditions" value='{}' name="conditions">
 	@include(Admin.'.layouts.datatable')
	<!--End Index-->
</div>
@endsection
