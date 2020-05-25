<!-- language -->
@extends('layouts.app')
@section('content')
  <section id="form-action-layouts">
    {!! Form::model($model,['route'=> $action,'id'=> class_basename($model),'method'=>'POST','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
      <div class="row match-height">
        <div class="col-md-3">
          @include(Setting.'.Syndicate_phone.create')
          @include(Setting.'.Syndicate_email.create')
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="from-actions-top-left">{{trans('neqabty.'.$method)}} {{trans('neqabty.'.class_basename($model))}}</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="card-content collpase show">
              <div class="card-body">
                  <div class="form-body" id="formbody">
                    @include(Admin.'.layouts.create')
                  </div>
                  <div class="form-actions right">
                    <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-floppy-o"></i> @lang("neqabty.submit") </button>
                    <a class="btn btn-danger mr-1" href="{{route(class_basename($model).'.index')}}"> <i class="fa fa-reply"></i> @lang("neqabty.cancel&back") </a>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    {!! Form::close()!!}
  </section>
  <script type="text/javascript">
  	$( document ).ready(function() { 
      $(".reset").click(function() {$(this).closest('form').find("input[type=text], textarea").val(""); });
      $(function () {$('select').select2()})
    });
  </script>
@endsection


