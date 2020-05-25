	<div class="card" style="box-shadow:0px 18px 21px 1px rgba(62, 57, 107, 0.07)">
		<div class="card-content">
			<div class="media align-items-stretch container-fluid row">
				<div class="col-md-4 col-sm-12 bg-gradient-x-info text-white media-body rounded text-center">
					<h5 class="text-white">{{$showData->points}}</h5>
					<p>{{$showData->user_id}}</p>
				</div>
			</div>
		</div>
	</div>	
	<a href="{{route('Wallet.edit',$showData->id)}}" class="btn btn-info btn-block"><b>Edit</b></a>