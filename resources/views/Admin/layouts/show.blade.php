<div class="container row">
@foreach($modelShower as $key => $value)
    @if     ($value['type']    == 'disable')
    @elseif ($value['type']    == 'text')        
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="check_{{$key}}">
                    {!! Form::text($key, null , ['class' => 'form-control','disabled'=>'disabled']) !!}
                </div>
            </div>
        </div> 
    @elseif ($value['type']    == 'email')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="check_{{$key}}">
                    {!! Form::email($key, null , ['class' => 'form-control','disabled'=>'disabled']) !!}
                </div>
            </div>
        </div> 
    @elseif ($value['type']    == 'textarea')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="check_{{$key}}">
                    {{ Form::textarea($key, null, ['class' => 'form-control','placeholder'=> trans('neqabty.'.$key),'id' => $key,'size' => $value['size'],'disabled'=>'disabled']) }}
                </div>
            </div>
        </div> 
    @elseif ($value['type']    == 'enum')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>                              
                <div class="check_{{$key}}">
                        {!! Form::select($key,[null=>'Please Select'] + $value['value'],null,['class' => 'form-control ','disabled'=>'disabled'])!!}
                </div>
            </div>
        </div>
    @elseif ($value['type']    == 'datetime')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }} </label>
                <div class='check_{{$key}} input-group' id='{{$key}}'>
                        {!! Form::text($key, null , ['class' => 'form-control','disabled'=>'disabled']) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    @elseif ($value['type']    == 'number')
       <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="check_{{$key}}">
                        {!! Form::text($key, null , ['class' => 'number form-control','disabled' => 'disabled']) !!}
                </div>
            </div>
        </div>                                       
    @elseif ($value['type']    == 'relationship')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>                              
                <div class="check_{{$key}}">
                       @php $relation = $value['value'] @endphp
                       {!! Form::text($key, @$model->$key->$relation  , ['class' => 'form-control','disabled'=>'disabled']) !!}
                </div>
            </div>
        </div>      
    @elseif ($value['type']    == 'password')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="check_{{$key}}">
                    {!! Form::password($key, ['class' => 'form-control','placeholder'=> trans('neqabty.'.$key),'disabled' => 'disabled']) !!}
                </div>
            </div>
        </div>
    @elseif ($value['type']    == 'file')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <div class="image_{{$key}} text-center"> <img class="img-circle filePhoto" style="border-radius: 50%;width: 150px;height: 150px;" src="{{url($model->$key)}}" alt="Photo"> </div> 
            </div>
        </div>  
    @elseif ($value['type']    == 'list')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>                              
                <div class="check_{{$key}}">
                    {!! Form::select($key,[null=>'Please Select'] + eval('return $'. $key . ';'),null,['class' => 'form-control','disabled' => 'disabled']) !!}
                </div>
            </div>
        </div>                    
    @elseif ($value['type']    == 'search')
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="input-group" class="check_{{$key}}">
                    {!! Form::text($key, null , ['class' => 'form-control','disabled' => 'disabled']) !!}
                    <span class="input-group-addon btn btn-xs btn-primary" id="{{$key}}-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </span>
                </div>
            </div>
        </div>
    @elseif ($value['type']    == 'checkbox')
        <div class="{{$key}} @if(isset($value['colmd'])){ {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-4 @endif ">
            <div class="">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="check_{{$key}}">
                    {!! Form::checkbox($key, null, null ,['data-on'=> 'Enabled' ,'data-off'=>'Disabled','data-toggle'=>'toggle','id'=>$key,'data-onstyle'=>'success','data-offstyle'=>'danger','disabled' => 'disabled']) !!}
                </div>
            </div>
        </div> 
    @else
        <div class="{{$key}} @if(isset($value['colmd'])) {{$value['colmd'] }} @elseif(isset($colmd)) {{$colmd}} @else  col-md-12 @endif ">
            <div class="form-group">
                <label for="{{$key}}">{{ trans('neqabty.'.$key) }}</label>
                <div class="check_{{$key}}">
                    {!! Form::text($key, null , ['class' => 'form-control','disabled'=>'disabled']) !!}
                </div>
            </div>
        </div>
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