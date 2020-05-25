<?php /*
	<div class="box box-primary">
		<div class="box-body box-profile">
			<img class="profile-user-img img-responsive img-circle" src="{{url($showData->picture)}}" alt="User profile picture">
			<h3 class="profile-username text-center"><u>{{$showData->name}}</u></h3>
			<p class="text-muted text-center"> {{$showData->job_title}} </p>
			<ul class="list-group list-group-unbordered">
				<li class="list-group-item">
					<b>email</b> <a class="pull-right" href="mailto:{{$showData->email}}"> {{$showData->email}}</a> </a>
				</li>
				<li class="list-group-item">
					<b>Username</b> <a class="pull-right">{{$showData->username}}</a>
				</li>
				<li class="list-group-item">
					<b>User Type</b> <a class="pull-right">{{$showData->usertype}}</a>
				</li>
			</ul>
		</div>
	</div>
*/?>



	<div class="card" style="box-shadow:0px 18px 21px 1px rgba(62, 57, 107, 0.07)">
		<div class="card-content">
			<div class="media align-items-stretch container-fluid row">
				<div class="col-md-4 col-sm-12 bg-gradient-x-info text-white media-body rounded text-center">
					<h5 class="text-white">{{$showData->name}}</h5>
					<span class="avatar avatar-online" style="width:80px"><img style="max-width:80px !important;height:80px !important" class="img-responsive" src="{{url($showData->picture)}}" alt="User profile picture"></span>
					<p>{{$showData->job_title}}</p>
				</div>
				<div class="col-md-8  col-sm-12">
					<p> <a href="mailto:{{$showData->email}}"> {{$showData->email}}</a></p>
					<p> {{$showData->username}} </p>
					<p> {{$showData->usertype}} </p>
					{{-- <h4>Total Sales</h4> <span>Monthly sales amount</span> --}}
				</div>
			</div>
		</div>
	</div>	
	<a href="{{route('User.edit',$showData->id)}}" class="btn btn-info btn-block"><b>Edit</b></a>
	{{-- <div class="p-2 text-center bg-info bg-darken-2 rounded-left">
		<hr style="border-top:1px solid rgb(217, 217, 217)">
		<p class="text-white">@lang('neqabty.email')</p>
		<p class="text-white">@lang('neqabty.username')</p>
		<p class="text-white">@lang('neqabty.roles')</p>
	</div> --}}