<style>
    .fileDiv {
    border: 2px dashed #0087F7;
    margin: auto;
    color: #1e9ff2;
    background: #1e9ff200;
    padding: 5px;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: 700;
    width:250px;
  }

  .fileDiv:hover {
    border: 2px dashed #0087F7;
    background: #0087F7;
    color: #ffffff;
    cursor: pointer;
    /* border: 2px dashed #fff; */
    /* transition: all .2s ease; */
  }

  .file-upload-btn:active {
    border: 0;
  }

  .fileDiv > input {
    position: absolute;
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    outline: none;
    opacity: 0;
    cursor: pointer;
  }
  .fileText{
    float: left;
  }
  .filePhoto{
    width: 100px;
    height: 100px;
    border-radius: 50%;
  }
</style>

@if ($errors->any())
  <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li style="color:#fff">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
@if(Session::has('success'))
  <div class="alert alert-success">
     {{ Session::get('success') }}
  </div>
@endif
<div class="row">
    @foreach($modelEditor  as $key => $value)
        @if ($value['type']   == 'file')
            
            <!--<div class="box box-widget widget-user col-md-12">
                <div class="widget-user-header bg-aqua-active"> </div>
                <div class="widget-user-image"> <img class="img-circle" src="{{url($model->img)}}" alt="User Avatar"> </div>
          </div>-->
        @elseif ($value['type']    == 'disable')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        <div class="form-control" style="background-color: #d2d6de" >{{$model->$key}}</div>                        
                    </div>
                </div>
            </div> 
        @elseif ($value['type']    == 'Cloudder')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                  <img class="img-circle img-bordered-sm" width="70" height="70"  src='{{Cloudder::show($model->$key, array("sign_url"=>true, "type"=>"private"))}}'>
            </div>         
        @elseif ($value['type']    == 'text')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::text($key, null , ['class' => 'form-control','id' => $key, $value['required'] => $value['required'] ,'autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div> 
        @elseif ($value['type']    == 'textarea')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {{ Form::textarea($key, null, ['class' => 'form-control','placeholder'=> trans('neqabty.'.$key),'id' => $key,'size' => $value['size'],$value['required'] => $value['required']]) }}
                    </div>
                </div>
            </div> 
        @elseif ($value['type']    == 'enum')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>                              
                    <div class="check_{{$key}}">
                        {!! Form::select($key,[null=>'Please Select'] + $value['value'],null,['class' => 'form-control ','id' => $key,$value['required'] => $value['required']])!!}
                    </div>
                </div>
            </div>
        @elseif ($value['type']    == 'checkbox')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::checkbox($key, $value['value'], null  ,['data-on'=>$value['data-on'] ,'data-off'=>$value['data-off'],'data-toggle'=>'toggle','id'=>$key,'data-onstyle'=>'success','data-offstyle'=>'danger']) !!}
                    </div>
                </div>
            </div> 
        @elseif ($value['type']    == 'datetime')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }} </label>
                    <div class='check_{{$key}} input-group' id='{{$key}}'>
                            {!! Form::text($key, null , ['class' => 'form-control','placeholder'=> trans('neqabty.'.$key),'id' => 'date-'.$key,$value['required'] => $value['required'],'autocomplete'=>'off']) !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <script type="text/javascript">$(function () {$('#{{$key}}').datetimepicker({format: '{{$value["format"]}}',viewMode: '{{$value["viewMode"]}}' });});</script>
                <!-- <script type="text/javascript">$(function () {$('#{{$key}}').datetimepicker({format: 'YYYY-MM-DD',viewMode: 'years'});});</script> -->
            </div>
        @elseif ($value['type']    == 'number')
           <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::text($key, null , ['class' => 'number form-control','placeholder'=> trans('neqabty.'.$key),'id' => $key,$value['required'] => $value['required'],'maxlength'=> $value["maxlength"] ,'autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div>      
            @elseif ($value['type']    == 'number2')
           <div style="visibility:hidden;width:330px;" class="provider_depart {{$key}} @if(isset($value['colmd'])){{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::text($key, null , ['class' => 'number form-control','placeholder'=> trans('neqabty.'.$key),'id' => $key,$value['required'] => $value['required'],'maxlength'=> $value["maxlength"] ,'autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div>  
     @elseif ($value['type']    == 'number3')
           <div style="visibility:hidden;width:330px;" class="parent_depart {{$key}} @if(isset($value['colmd'])){{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::text($key, null , ['class' => 'number form-control','placeholder'=> trans('neqabty.'.$key),'id' => $key,$value['required'] => $value['required'],'maxlength'=> $value["maxlength"] ,'autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div>  
        @elseif ($value['type']    == 'relationship')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>                              
                    <div class="job" class="check_{{$key}}">
                        {!! Form::select($key,[null=>'Please Select'] +  eval('return $'. rtrim($key,"[]"). ';'),null,['class' => 'form-control','id' => rtrim($key,"[]"),$value['required'] => $value['required']   ,$value['multiple'] => $value['multiple']  ])!!}
                    </div>
                </div>
            </div>    
            @elseif ($value['type']    == 'relationship2')
            <div  style="visibility:hidden;width:330px;" class="medical_depart {{$key}} @if(isset($value['colmd'])){{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>                              
                    <div   class="check_{{$key}}">
                    {!! Form::select($key, [null=>'Please Select'] + eval('return $'. rtrim($key,"[]"). ';'),null,['class' => 'form-control','id' => rtrim($key,"[]") ,$value['required'] => $value['required'],$value['multiple'] => $value['multiple'] ])!!}
                    </div>
                </div>
            </div>     
        @elseif ($value['type']    == 'password')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::password($key, ['class' => 'form-control','placeholder'=> trans('neqabty.'.$key),'id' => $key,$value['required'] => $value['required'],'autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div>
        @elseif ($value['type']    == 'file')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">                    
                    <div class="image_{{$key}} text-center"> <img class="img-circle filePhoto" src="{{url($model->$key)}}" alt="Photo"> </div>                    
                    <div class="check_{{$key}} fileDiv text-center">
                        <div id="text_{{$key}}" class="fileText"> </div>
                        {!! Form::file($key , ['value'=>$model->$key,'class' => 'form-control','id' => $key,$value['required'] => $value['required'],'autocomplete'=>'off','onchange'=>'readURL('.$key.');']) !!} 
                    </div>
                </div>
            </div>
            <style>
                .fileDiv:before {content: "@lang('neqabty.'.$key.'_photo')";}
            </style>
        @elseif ($value['type']    == 'list')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::select($key,[null=>'Please Select'] + eval('return $'. $key . ';'),null,['class' => 'form-control ','id' => $key])!!}
                    </div>
                </div>
            </div> 
            @elseif ($value['type']    == 'list2')
            <div class="medical_depart" style="visibility:hidden;width:330px;" class="{{$key}} @if(isset($value['colmd'])){{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>                              
                    <div class="check_{{$key}}">
                        {!! Form::select($key,[null=>'Please Select'] + eval('return $'. $key . ';'),null,['class' => 'form-control ','id' => $key,$value['required'] => $value['required']])!!}
                    </div>
                </div>
            </div>                     
        @elseif ($value['type']    == 'email')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::email($key, null , ['class' => 'form-control','id' => $key, $value['required'] => $value['required'] ,'autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div> 
        @elseif ($value['type']    == 'data-mask')
            <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
                <div class="form-group">
                    <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                    <div class="check_{{$key}}">
                        {!! Form::text($key, null , ['class' => 'form-control','id' => $key, $value['required'] => $value['required'] ,'autocomplete'=>'off','data-inputmask'=>   $value['data-inputmask'],'data-mask'=>'data-mask']) !!}
                    </div>
                </div>
            </div> 
            <script type="text/javascript">$(function () { $('[data-mask]').inputmask()});</script>
        @endif
    @endforeach
</div>
@php
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
@endphp
<script>

    $(document).ready(function() {
       
});

$(function () {
    alert($('li.select2-selection__choice').attr('title'));
});

    function readURL(input) {    
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            $('.'+input.name+' .filePhoto').attr('src', e.target.result);
            $('.'+input.name+' .fileText').html('<div style="display:none">'+input.files[0].name+'</div>');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            removeUpload();
        }     
    };
    function removeUpload() {
        $('.'+input.name+' .file-upload-input').replaceWith($('.'+input.name+' .file-upload-input').clone());
    }
 $('.job').on('change', function() {
   if($('.job').find('li.select2-selection__choice').length != 0){
          if($('li.select2-selection__choice').attr('title') == 'medical'){
              $('.medical_depart').css('visibility','visible');
              $('.provider_depart').css('visibility','hidden');
              $('.parent_depart').css('visibility','hidden');
          }else if($('li.select2-selection__choice').attr('title') == 'provider'){
              $('.provider_depart').css('visibility','visible');
              $('.medical_depart').css('visibility','hidden');
              $('.parent_depart').css('visibility','visible');
              $('.medical_depart').css('visibility','hidden');
          }else if($('li.select2-selection__choice').attr('title') == 'superprovider'){
              $('.provider_depart').css('visibility','visible');
              $('.medical_depart').css('visibility','hidden');
              $('.parent_depart').css('visibility','hidden');
          }else{
            $('.provider_depart').css('visibility','hidden');
              $('.medical_depart').css('visibility','hidden');
              $('.parent_depart').css('visibility','hidden');
          }
     }else{
        $('.medical_depart').css('visibility','hidden');
        $('.provider_depart').css('visibility','hidden');
          $('.parent_depart').css('visibility','hidden');
     }
 
});
</script>          
       