<!-- language -->
@extends('layouts.app')
@section('content')
  <section id="form-action-layouts">
    <div class="row match-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title" id="from-actions-top-left">{{trans('neqabty.'.$method)}} {{trans('neqabty.'.class_basename($model))}} # {{$model->id}} </h4>
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
              {!! Form::model($model,['route'=> [$action,$model->id],'id'=> class_basename($model),'method'=>'PUT','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
                <div class="form-body" id="formbody">
                  @include(Admin.'.layouts.edit')
                </div>
                <div class="form-actions right">
                  <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-floppy-o"></i> @lang("neqabty.submit") </button>
                  <a class="btn btn-danger mr-1" href="{{route(class_basename($model).'.index')}}"> <i class="fa fa-reply"></i> @lang("neqabty.cancel&back") </a>
                </div>
              {!! Form::close()!!}
            </div>
          </div>
        </div>
      </div>       
    </div>
  </section>

  <script type="text/javascript">
    $( document ).ready(function() {  $(function () { $('select').select2();})});
  </script>
@endsection

