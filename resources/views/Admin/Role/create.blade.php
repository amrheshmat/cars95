<!-- language -->
@extends('layouts.app')
@section('content')
  @php $roles = Ultraware\Roles\Models\Role::pluck('slug','id')->toArray(); @endphp
  <section id="form-action-layouts">
    <div class="row match-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title" id="from-actions-top-left"> @lang('neqabty.'.$method) @lang('neqabty.'.class_basename($model)) </h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
              <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="card-content collpase show">
            <div class="card-body">
              {!! Form::model($model,['route'=> $action,'id'=> class_basename($model),'method'=>'POST','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
                <div class="form-body" id="formbody">
                  @include(Admin.'.layouts.create')
                </div>

                <ul class="todo-list ui-sortable table-responsive">
                  <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">Model</th>
                          @php $headOfRoutes = array(); @endphp
                          @foreach ($model->getAllPermission() as $routes => $subController)
                            @php $headOfRoutes[] = substr($routes,strlen($subController)+1); @endphp
                          @endforeach
                          @foreach (array_unique($headOfRoutes) as $key => $value)
                            <th > <input type="checkbox" class="select_all" id="td-{{$key}}" > @lang('neqabty.'.$value) </th>
                          @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      @foreach (array_unique($model->getAllPermission()) as $routes => $controller)
                        <tr role="row" class="odd">
                          <td class="">@lang('neqabty.'.$controller)</td>
                            @foreach (array_unique($headOfRoutes) as $key => $value)
                                <td>
                                  @php $check = $controller.'.'.$value @endphp

                                  @if (array_key_exists($check, $model->getAllPermission()) )
                                      <input name="permissions[{{$controller}}.{{$value}}]" type="checkbox" class="td-{{$key}}" onclick="myFunction('td-{{$key}}')">
                                  @else
                                      <!-- <input  type="checkbox"  disabled="disabled"> -->
                                  @endif
                                </td>                            
                            @endforeach 
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </ul>


                <div class="form-actions right">
                  <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-floppy-o"></i> @lang("neqabty.submit") </button>
                  <a class="btn btn-danger mr-1" href="{{route(class_basename($model).'.index')}}"> <i class="fa fa-reply"></i> @lang("neqabty.can2cel") </a>
                </div>
              {!! Form::close()!!}
            </div>
          </div>
        </div>
      </div>       
    </div>
  </section>

  <script type="text/javascript">
  	$( document ).ready(function() { 
      $(".reset").click(function() {$(this).closest('form').find("input[type=text], textarea").val(""); });
      $(function () {$('select').select2()})
    });
    $(document).ready(function(){
      $('.select_all').on('click',function(){
          var checkboxs = this.id;
          if(this.checked){
              $('.'+checkboxs).each(function(){
                  this.checked = true;
              });
          }else{
              $('.'+checkboxs).each(function(){
                  this.checked = false;
              });
          }
      });    
      $('.checkbox').on('click',function(){
          if($('.checkbox:checked').length == $('.checkbox').length){
              $('#select_all').prop('checked',true);
          }else{
              $('#select_all').prop('checked',false);
          }
      });
    });
    function myFunction(p1) {
      if($('.'+p1+':checked').length == $('.'+p1).length){
        $('#'+p1).prop('checked',true);
      }else{
        $('#'+p1).prop('checked',false);
      }
    }
  </script>
@endsection


