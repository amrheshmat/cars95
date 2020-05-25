@extends('layouts.app')
@section('content')
<br/>
<div class="container-fluid" style="min-height: 900px">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="transactions.id">
	<input type="hidden" id="model"  	 value="Transaction">
	<input type="hidden" id="groupby" 	 value="transactions.id">
	<input type="hidden" id="path" 	 	 value="{{Payment}}">
	<input type="hidden" id="conditions" value='{}' name="conditions">
 	@include(Admin.'.layouts.datatable')
	<!--End Index-->
</div>
@endsection
