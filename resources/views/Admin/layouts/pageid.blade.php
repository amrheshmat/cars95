<tbody  id="data" class="insertData text-center">
	@foreach($datatable as $row )
		<tr style="cursor:pointer" class="loadingrow tr clickable-row" data-edit="{{URL::route(class_basename($model).'.edit',   $row->id)}}" >
			@foreach($model->dataTable as $key => $column)
				@if ($column["search_type"] == 'link')
					<td class="col-{{$key}}"><a href="{{URL::route(class_basename($model).'.show',eval('return $row->'.$column["query_as"].';'))}}">{!! eval('return $row->'.$column["query_as"].';') !!}</a></td>
				@elseif ($column["search_type"] == 'img')
					@php $src = eval('return $row->'.$column["query_as"].';'); @endphp 
					<td class="col-{{$key}}">
						<div class="user-block">
							<img style="float: none !important;border-radius: 50%;width: 35px;height: 35px;" class="img-circle img-bordered-sm" src="{!! asset($src) !!}" alt="@lang('neqabty'.$key)">
							@if(array_key_exists('link', $column)) <a style="display: block;width: 100%;" href="{{URL::route($column["link"]["route"],eval('return $row->'.$column["link"]["value"].';') )}}">{{eval('return $row->'.$column["link"]["value"].';')}}</a> @endif
						</div>
					</td>
				@elseif($column["search_type"] == 'cloudImg')
					<td class="col-{{$key}}"><div class="user-block">
						@php $src = eval('return $row->'.$column["query_as"].';'); @endphp 
						<img style="float: none !important" class="img-circle img-bordered-sm" src='{{Cloudder::show($src, array("sign_url"=>true, "type"=>"private"))}}'>
						@if(array_key_exists('link', $column)) <a style="display: block;width: 100%;" href="{{URL::route($column["link"]["route"],eval('return $row->'.$column["link"]["value"].';') )}}">{{eval('return $row->'.$column["link"]["value"].';')}}</a> @endif
					</td>
				@elseif($column["search_type"] == 'ManyToMany' || $column["search_type"] == 'FIND_IN_SET')
					@php $array = ltrim(eval('return $row->'.$column["query_as"].';'), ',');$array 	= explode(',',$array ); @endphp
					<td class="col-{{$key}}"> @for($x = 0; $x < count($array); $x++)  <span class="label label-default" style="margin-right: 2px;">{{$array[$x]}} </span>  @endfor </td>
				@elseif($column["search_type"] == 'list')
					@php $array = ltrim(eval('return $row->'.$column["query_as"].';'), ',');$array 	= explode(',',$array ); @endphp
					<td class="col-{{$key}}"> @for($x = 0; $x < count($array); $x++){!! $array[$x] !!}@endfor </td>
				@else
					<td class="col-{{$key}}">
						@if(array_key_exists('link', $column))
							<a style="display: block;width: 100%;" href="{{URL::route($column["link"]["route"],eval('return $row->'.$column["link"]["value"].';') )}}">{!! eval('return $row->'.$column["query_as"].';') !!}</a>
						@else
							{!! eval('return $row->'.$column["query_as"].';') !!}
						@endif
					</td>
				@endif
			@endforeach
				@permission([strtolower(class_basename($model)).'.show',strtolower(class_basename($model)).'.edit',strtolower(class_basename($model)).'.destroy'])
					<td class="col-takeAction text-center">
						 <div class="btn-group" style="min-width: 72px">
		 			 		@permission(strtolower(class_basename($model)).'.show') 	<a href="{{URL::route(class_basename($model).'.show',   $row->id)}}" data-id ="{{$row->id}}" class="tableShowItems btn btn-sm round btn-outline-info"  ><i class=" fa fa-eye "></i></a> 				@endpermission
		 			 		@permission(strtolower(class_basename($model)).'.edit')		<a href="{{URL::route(class_basename($model).'.edit',   $row->id)}}" data-id ="{{$row->id}}" class="tableEditItems btn btn-sm round btn-outline-primary"  ><i class=" fa fa-pencil-square-o"></i></a> 	@endpermission
		 			 		@permission(strtolower(class_basename($model)).'.destroy') 	<a href="{{URL::route(class_basename($model).'.destroy',$row->id)}}" data-id ="{{$row->id}}" class="tableDeleteItems btn btn-sm round btn-outline-danger"><i class=" fa fa-trash-o"></i></a>         			@endpermission
						 </div>
					</td>
				@endpermission
		</tr>
	@endforeach
</tbody>
<tr>
	<td colspan="{{count($model->getCasts())+1}}"> 
		<div class="row">
			<div id="loadingcountReplace">@lang('neqabty.show') {!! $datatable->count() !!} @lang('neqabty.of') {!! $datatable->total() !!}</div>
			<div id="loadpaginateReplace">{!! str_replace(array('/?','<li class="active"',/*'<li',*/'<a','<span'),array('?','<li class="paginate_button page-item active" ',/*'<li class="paginate_button page-item" ',*/'<a class="page-link" ','<span class="page-link" '),$datatable->appends(['search' => Input::get('search')])->appends(['sort' => Input::get('sort')])->render())!!} </div>
		</div>
	</td>
</tr>