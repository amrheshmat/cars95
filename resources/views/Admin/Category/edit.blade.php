<!-- language -->
@extends('layouts.app')
@section('content')
  <div class="container-fluid">
    <div class="row">
      {!! Form::model($model,['route'=> [$action,$model->id],'id'=> class_basename($model),'method'=>'PUT','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title text-default">{{trans('form.'.$method)}} {{trans('form.'.class_basename($model))}} # {{$model->id}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="box-body" id="formbody">
                @include(Admin.'.layouts.edit')
                <div class="row">
                	<div class="12 pull"></div>
                </div>
              </div>
              <div class="box-footer" id="formbody">
              <button class="btn bg-primary pull-right"> Submit </button>
              </div>
            </div>
          </div>
        </div>
      {!! Form::close()!!}
    </div>      
  </div>
@endsection

