<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style type="text/css">
	.classPageID  .select2-selection__rendered{
		margin-top:-6px !important
	}
	.classPageID  .select2-container--default .select2-selection--single{
		height: 30px !important
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered{
		float:right;
	}
	.classPageID .select2-container--default .select2-selection--single{
		height:40px  !important;
	}
	span.select2-selection.select2-selection--single{
		border-radius:20px
	}
	span.select2-selection__rendered{
		line-height:40px !important;
	}
	.select2-container{
		/* display:inherit; */
	}
	span.select2-selection.select2-selection--single {
        outline: none;
    }
	ul.pagination{
		float : left;		
	}
</style>
<div class="row">
	<div class="col-md-12">
	    <div class="card">
			<div class="card-header" id="searchdatatabel" style="border-bottom:1px solid #1e9ff2;min-height: 50px;">
				<h4 class="card-title">
					@permission(strtolower(class_basename($model)).'.create') 	
						<form id="exportreport" method="POST" action="#"  enctype="multipart/form-data">
							<div class="input-group">
								<span class="input-group-btn CreateAdd">
									<input type="hidden" name="_token" 	value="{{ csrf_token() }}">
									<input type="hidden" name="model" 	value="{{class_basename($model)}}" >
									<a class="btn btn-info round box-shadow-2 px-2" href="{{URL::route(class_basename($model).'.create')}}" title="Create" style="display:inline;vertical-align:unset;border:0px"><i class="ft-plus-circle icon-left"></i> @lang('neqabty.CreateNew'.class_basename($model)) </a>
									<?php /*
										<!-- <a class="btn btn-primary" href="javascript:document.getElementById('exportreport').submit();"><i class="fa fa-download"></i></a> -->
										<!-- <a class="btn btn-primary" onclick="saveAsExcel('tableToExcel', '{{class_basename($model)}}.xls')"><i class="fa fa-file-excel-o"></i></a> -->
									*/?>
								</span>
							</div>
						</form>
					@endpermission
				</h4>
				{{-- <div class="col-md-3 col-sm-12 	text-center" >
					{{trans('crm.datatabel'.strtolower(class_basename($model)))}}
					<div class="input-group"> 
						<input type="text" class="form-control input-sm" placeholder="Search for..." name="search" id="search" onchange="pageid();">
						<span class="input-group-btn"><button class="btn btn-primary btn-sm" onclick="pageid();" type="button"><i class="fa fa-search"></i></button></span>
					</div>
				</div> --}}
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li onclick="pageid();" style="cursor: pointer;"><i class="ft-rotate-cw"></i></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
            <div class="card-content collapse show">
				<div class="row" style="padding:10px">
					<div class="col-md-3 text-right">
						<div class="box-tools">
							<select class="form-control" id="rows" onchange="pageid();" style="float:right">
								@for ($i = 10; $i <= 200; $i=$i+10) 
									<option>{{$i}}</option>
								@endfor
								<option value="1000000000000000">0</option>
							</select>
						</div>
					</div>
				</div>
				<div class="box-body table-responsive">
					<div class="classPageID ">
						<input type="hidden" id="ordertype" name="ordertype" value="desc">
						<input type="hidden" id="orderby"    name="orderby"   value=" @if(!empty($orderby)) {{$orderby}} @else {{$model->getKeyName()}}  @endif">
						<table style="white-space: nowrap;" id="tableToExcel" class="table table-hover table-bordered table-striped"> <!--  -->
							<thead id="header">
								<tr id="tfooter">									
									@foreach($tableDesign as $key => $value)
										@if(isset($value['name'])) @php $name = $value['name']; @endphp @else @php $name = $value['query_value']; @endphp @endif
										@if($value['search_type'] == 'equal' || $value['search_type'] == 'link' || $value['search_type'] == 'like' || $value['search_type'] == 'Having')
											<th class="col-{{$value['query_value']}}" width="6%">
												<input data-type="{{$value['search_type']}}" name="{{$name}}" id="{{$value['query_value']}}" onkeyup='pageid();' class="form-control round text-center tfooter-input"></input>
											</th>
										@elseif($value['search_type'] == 'ENUM' || $value['search_type'] == 'FIND_IN_SET' || $value['search_type'] =='list')
											<!--  -->
											@if(@$value['multiple'])
												<th class="col-{{$value['query_value']}}" width="6%">{!! Form::select($name,array_combine($value["extra_value"], $value["extra_value"]),null,['class' => 'filter form-control round text-center tfooter-input','data-name'=>$value['query_value'],'data-type'=>$value['search_type'],'id' => $key,'onchange'=>'pageid();','multiple'=> @$value['multiple']])!!}</th>
											@else
												<th class="col-{{$value['query_value']}}" width="6%">{!! Form::select($name,[null =>'Select'] + array_combine($value["extra_value"], $value["extra_value"]),null,['class' => 'filter form-control round text-center tfooter-input','data-name'=>$value['query_value'],'data-type'=>$value['search_type'],'id' => $key,'onchange'=>'pageid();','multiple'=> @$value['multiple']])!!}</th>
											@endif
										@elseif($value['search_type'] == 'relation')
											<?php
												$list = $model::with($key)->groupBy(str_replace('_hasOne','',$key))->get();
												$array = [];
												foreach ($list as $option) {
													if(!empty($option->$key)){
														if (is_array($value["extra_value"])) {
															$array = array_prepend($array,eval('return $option->$key->'. $value["extra_value"][0].';').' '.eval('return $option->$key->'. $value["extra_value"][1].';'),$option->$key->id);
														}else{
															
															$array = array_prepend($array,eval('return $option->$key->'.$value["extra_value"].';'),$option->$key->id);
														}
														
													}else{
														$array = array();
													}
												}													
											?>
											<th class="col-{{str_replace('_hasOne','',$key)}}" width="6%">{!! Form::select(str_replace('_hasOne','',$key),[null =>'Please Select'] + $array ,null,['class' => 'filter form-control round text-center tfooter-input','style'=>'min-width: 120px;','data-type'=>$value['search_type'],'data-name' => str_replace('_hasOne','',$key),'id' => str_replace('_hasOne','',$key),'onchange'=>'pageid();'])!!}</th></th>
										@elseif($value['search_type'] == 'getAllList')
											<?php
												$list = '\App\\'.$value['extra_value']['model'];
												$list = $list::pluck($value['extra_value']['index'],$value['extra_value']['value'])->toArray();
											?>
											<th class="col-{{$value['query_value']}}" width="6%">
												@if(@$value['multiple'])
													{!! Form::select($name,$list ,null,['class' => 'filter form-control round text-center tfooter-input','data-name'=>$value['query_value'],'data-type'=>'getAllList','id' => $key,'onchange'=>'pageid();','multiple'=> @$value['multiple']])!!}
												@else
													{!! Form::select($name,[null =>'Please Select'] + $list ,null,['class' => 'filter form-control round text-center tfooter-input','data-name'=>$value['query_value'],'data-type'=>'getAllList','id' => $key,'onchange'=>'pageid();'])!!}
												@endif
											</th>
										@elseif($value['search_type'] == 'datatime')
											<th class="col-{{$value['query_value']}}" width="8%">
												<input data-type="{{$value['search_type']}}"  name="{{$value['query_value']}}"  id="{{$value['query_value']}}"  onchange='pageid();'  class="form-control round text-center tfooter-input" value="" />
												<script type="text/javascript">
													$(function() {
														var qValue 	= "{{$value['query_value']}}";
														$('input[name="'+qValue+'"]').daterangepicker({
															timePicker: false,
															autoUpdateInput: false,
															opens: 'left',
															locale: {format: 'YYYY-MM-DD',cancelLabel: 'Clear'},
															ranges: {
																'Today': [moment(), moment()],
																'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
																'Last 7 Days': [moment().subtract(6, 'days'), moment()],
																'Last 30 Days': [moment().subtract(29, 'days'), moment()],
																'This Month': [moment().startOf('month'), moment().endOf('month')],
																'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
															}
														}, function(start, end, label) {
															$('input[name="'+qValue+'"]').val(start.format('YYYY-MM-DD 00:00:00') + ' - ' + end.format('YYYY-MM-DD 23:59:59'));
															pageid();

														});
														$('input[name="'+qValue+'"]').on('cancel.daterangepicker', function(ev, picker) {
															$('input[name="'+qValue+'"]').val('');
															pageid();
														});
													});
												</script>
											</th>
										@else
											<th class="col-{{$value['query_value']}}" width="6%"></th>
										@endif
									@endforeach
									@permission([strtolower(class_basename($model)).'.show',strtolower(class_basename($model)).'.edit',strtolower(class_basename($model)).'.destroy'])
										<th width="6%" class="col-takeAction"></th>
									@endpermission
								</tr>
								<tr>
									@foreach($tableDesign as $key => $value)
										<th class="col-{{$value['query_as']}}" class="text-center">
											<div class="text-center">@lang('neqabty.'.$key)
												<span style="cursor:pointer" name="{{$value['query_as']}}" type="asc" class="sort fa fa-sort pull-right text-primary"></span>
											</div>
										</th>
									@endforeach
									@permission([strtolower(class_basename($model)).'.show',strtolower(class_basename($model)).'.edit',strtolower(class_basename($model)).'.destroy'])
										<th width="6%" class="text-center col-takeAction">@lang('neqabty.action')</th>
									@endpermission
								</tr>
							</thead>
							<tbody class="insertData text-center">
								@foreach($datatable as $row )
									<tr style="cursor:pointer" class="tr clickable-row" data-edit="{{URL::route(class_basename($model).'.edit',   $row->id)}}" >
										@foreach($model->dataTable as $key => $column)
											@if ($column["search_type"] == 'link')
												<td class="col-{{$key}}"><a href="{{URL::route(class_basename($model).'.show',eval('return $row->'.$column["query_as"].';'))}}">{!! eval('return $row->'.$column["query_as"].';') !!}</a></td>
											@elseif($column["search_type"] == 'img')
												@php $src = eval('return $row->'.$column["query_as"].';'); @endphp 
												<td class="col-{{$key}}">
													<div class="user-block">
														<img style="float: none !important;border-radius: 50%;width: 35px;height: 35px;" class="img-circle img-bordered-sm" src="{!! asset($src) !!}" alt="@lang('neqabty.'.$key)">
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
												<td class="col-{{$key}}"> @for($x = 0; $x < count($array); $x++)  <span class="label label-default" style="margin-right: 2px;">{!! $array[$x] !!} </span>  @endfor </td>
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
														@permission(strtolower(class_basename($model)).'.show') 	<a href="{{URL::route(class_basename($model).'.show',   $row->id)}}" data-id ="{{$row->id}}" class="tableShowItems btn btn-sm round btn-outline-info"><i class="fa fa-eye "></i></a> @endpermission
														@permission(strtolower(class_basename($model)).'.edit')		<a href="{{URL::route(class_basename($model).'.edit',   $row->id)}}" data-id ="{{$row->id}}" class="tableEditItems btn btn-sm round btn-outline-primary"><i class="fa fa-pencil-square-o"></i></a> @endpermission
														@permission(strtolower(class_basename($model)).'.destroy') 	<a href="{{URL::route(class_basename($model).'.destroy',$row->id)}}" data-id ="{{$row->id}}" class="tableDeleteItems btn btn-sm round btn-outline-danger"><i class="fa fa-trash"></i></a> @endpermission
													</div>
											</td>
										@endpermission
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="box-footer container-fluid">
					<div class="row">
						<div class="col-md-6" id="loadingcount" style="line-height:60px">
							<div class="loadingcountReplace"> @lang('neqabty.show') {!! $datatable->count() !!}  @lang('neqabty.of') {!! $datatable->total() !!} </div>
						</div>

						<div class="col-md-6" id="loadpaginate">
							<div class="loadpaginateReplace"> {!! str_replace(array('/?','<li class="active"',/*'<li',*/'<a','<span'),array('?','<li class="paginate_button page-item active" ',/*'<li class="paginate_button page-item" ',*/'<a class="page-link" ','<span class="page-link" '),$datatable->render()) !!} </div>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
  		$(document).on('click','.tableShowItems',function(e) {
  			// body...
  			e.preventDefault();
  			var link = $(this).attr('href');
  			var id   = $(this).data('id');
  			$.dialog({
  				columnClass: '{{{ $class or "col-md-4 col-md-offset-4"}}}',
  				title  : '@lang("neqabty.".class_basename($model)) # '+id, 
	  			content: 'URL:'+link+'?ajax=1',
				rtl: true,
	  		});
  		});

		$(document).on('click','.tableDeleteItems',function(e){ 
  			e.preventDefault();
		    var me      = $(this);
		    var route 	= $(this).attr('href');
		    var token   = "{{ csrf_token() }}";
		    $.confirm({
		        // icon                : 'glyphicon glyphicon-remove',
		        animation           : 'rotateX',
		        closeAnimation      : 'rotateXR',
		        title               : '@lang("neqabty.deleterecord") #'+ me.data('id'),
		        content             : '<center>@lang("neqabty.areusuredelete")</center>',
	            buttons: {
        	        specialKey: {
			            text: '@lang("neqabty.yeaimsure")',
			            keys: ['enter'],
            			btnClass: 'btn-danger',
        				action: function () {
            				// here the button key 'hey' will be used as the text.
	        			 	 $.ajax({
				                url     : route,
				                type    : 'POST',
				                data    : {_method: 'delete', _token :token},
				                dataType:'json',           
				                success : function(data){
									me.parent().parent().parent().fadeOut(800, function() { $(this).remove(); });    
								},
								error : function(data){
									console.log(data);
									$.alert({										
										animation           : 'rotateX',
										closeAnimation      : 'rotateXR',
										title               : '@lang("neqabty.error") #'+ me.data('id'),
										content             : '<center>'+data.responseJSON+'</center>',
									});								    
				                },
				            });
					    },
    				},
			        cancel: {
			            text: '@lang("neqabty.cancel")',
			            btnClass: 'btn-info', // multiple classes.
					 	close: function () {
					 		btnClass: 'btn btn-blue'
					 	},
		            
		        	},
    			},
		  	});
	  	});
        
      	$(function () {
        	//Initialize Select2 Elements
			$('select').select2();
          	getData('autoload');
      	})
      	
    });
    
	var currentRequest;
	// GAT Data
	function getData(page = null,url = '{{url("Ajaxtable?")}}',dataType = 'json',sendType = 'get') {
		if(currentRequest){ currentRequest.abort(); }
		var rows        = $('#rows :selected').text();
        var subpageid   = $('#changepageid').val();
        var model       = $('#model').val();
        var search      = $('#search').val();
        var orderby     = $('#orderby').val();
        var ordertype   = $('#ordertype').val();
        var groupby     = $('#groupby').val();
        var key         = $('#key').val();
        var path        = $('#path').val();
        if ($('#conditions') != null){var conditions= JSON.parse($('#conditions').val());}else {var conditions = null;}
		//GET Footer filtratoin
			var columns = new Object();
        	var div     = document.getElementById("tfooter");
		//GET SELECT
        	var selects = div.getElementsByTagName("select");
			for ( var i = 0; i < selects.length; i++ ) {
				var key     = $(selects[i]).attr("id");
				var type    = $(selects[i]).data('type');
				var name     = $(selects[i]).data("name");
				var value    = $("#"+key).find(":selected").val();
				var obj      = $("#"+key).select2('data');
				var newObj 	 = []; 
				$.each(obj, function(key, value) {if(obj[key]['element']['value'] != ""){var values = obj[key]['element']['value'];newObj.push(values);}	});
				if(value != undefined){if (value.length > 0) {columns[name] = {value:newObj, type:type,element:newObj};}}
			}
		//GET input
			var inputs  = div.getElementsByTagName("input");
			for ( var i = 0; i < inputs.length; i++ ) {
				var name    = $(inputs[i]).attr("id");
				var value   = $(inputs[i]).val();
				var type    = $(inputs[i]).data('type');
				if (value.length > 0) {columns[name] = {value:value, type:type};}
			}
			
			
            if(Object.getOwnPropertyNames(columns).length === 0 && page == 'autoload'){
                return false
            }

			
		//Download
			if(sendType == 'post'){
				var query = {path:path,key:key,columns:columns,groupby:groupby,conditions:conditions,model:model,page:page,search:search,ordertype:ordertype,orderby:orderby,rows:rows,subpageid:subpageid}
				var url = url +'?'+ $.param(query)
				window.location = url;
				return false;
			}
		// Page loading Icon
			$colspan = +inputs.length + +selects.length + 3;
			if (subpageid != null) {
				$('.'+subpageid+'insertData').html("<tr><td colspan='"+$colspan+"'><img src='{{asset('http://www.redesvivamarketing.es/images/partners/icons/submit_load.gif')}}'></td></tr>");
			}else{
				$(".insertData").html("<tr><td colspan='"+$colspan+"'><img width='50px' height='50px' src='{{asset('http://www.redesvivamarketing.es/images/partners/icons/submit_load.gif')}}'></td></tr>");
			}
		//AJAX
			currentRequest = $.ajax({
				url     :url,
				data    :{path:path,key:key,columns:columns,groupby:groupby,conditions:conditions,model:model,page:page,search:search,ordertype:ordertype,orderby:orderby,rows:rows,subpageid:subpageid},
				dataType:dataType,
				type    :sendType,
				success : function(data){
				if (subpageid != null) {
					$('#loadpaginate').html($(data).find('#loadpaginateReplace'));
					$('#loadingcount').html($(data).find('#loadingcountReplace'));
					$('.'+subpageid+'insertData').html($(data).find('.loadingrow'));
				}else{
					// $('#loadpaginate').html($(data).find('#loadpaginate'));
					// $('#loadingcount').html($(data).find('#loadingcount'));
					// $('.insertData').html($(data));
					$('#loadpaginate').html($(data).find('#loadpaginateReplace'));
					$('#loadingcount').html($(data).find('#loadingcountReplace'));
					$('.insertData').html($(data).find('.loadingrow'));
				}
				},
				error : function(data){
					$('.insertData').html("<tr><td colspan='"+$colspan+"'>"+data.responseJSON + '</td>');
					$('#loadpaginate').html();
					$('#loadingcount').html();
				},
			});

        	return false;
		
		}
	
	
	function pageid(){
		if ($('.pagination > .active span').text() != null){var page= $('.pagination > .active span').text();}else {var page = null;}	
		getData(page);
		// var name    = $(selects[i]).data('name');
		// to solve . issue 
		//          if (name.includes(".") !== false) {
		//          	var checkname 	= name.replace(".", "\\.");
		//          	var value   = $("#"+checkname).find(":selected").val();
		// }else{}

        //Go to Ajax Controller
    };

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();
        var page        = $(this).attr('href').split('page=')[1];
        getData(page);

    });
	$(document).on('click','#axadownload a',function(e){
        e.preventDefault();
		var page = null;
        getData(page,url = '{{ url(ucfirst(class_basename($model))."/export") }}',dataType = 'json',sendType = 'post');
    });

    $(document).on('click','.sort',function(e){
        var sort = $('#ordertype').val();
        if (sort == 'desc') {
            $('#ordertype').val('asc');
        }else{
            $('#ordertype').val('desc');
        }
        $('#orderby').val($(this).attr('name'));
        pageid();
    });
</script>