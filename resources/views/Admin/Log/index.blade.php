@extends('layouts.app')
@section('content')
	<div class="container-fluid">
		<input type="hidden" id="key" 	 	 value="logs.id">
		<input type="hidden" id="model"  	 value="Log">
		<input type="hidden" id="groupby" 	 value="logs.id">
		<input type="hidden" id="path" 	 	 value="{{Admin}}">
		<input type="hidden" id="conditions" value='{}' name="conditions">
		@include(Admin.'.layouts.datatable')
	</div>
@endsection