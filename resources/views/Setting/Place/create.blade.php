<!-- language -->
@extends('layouts.app')
@section('content')
  <section id="form-action-layouts">
    {!! Form::model($model,['route'=> $action,'id'=> class_basename($model),'method'=>'POST','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
      <div class="row match-height">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="from-actions-top-left">{{trans('neqabty.'.$method)}} {{trans('neqabty.'.class_basename($model))}}</h4>
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


        <div class="col-md-4">          
          <div class="fileDiv">
            <p>Drop Files here to upload</p>
            <input class="form-control" id="placeimage"  onchange="readURL2(placeimage);" name="placeimage[]" type="file"  accept="image/*" multiple>
          </div>
          <section id="image-gallery" class="card">
            <div class="card-header">
              <h4 class="card-title">@lang('neqabty.imagegallery')</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="card-content  collpase show">
              <div class="card-body  my-gallery">						
                <div class="row filePhotoPlace">                  
                </div>
              </div>          
            </div>        
          </section>
        </div>
      </div>
    {!! Form::close()!!}
  </section>
  <script type="text/javascript">
  	$( document ).ready(function() { 
      // $(".reset").click(function() {$(this).closest('form').find("input[type=text], textarea").val(""); });
      $(function () {$('select').select2()})
    });
  </script>


<style>
  .fileDiv {
    border: 2px dashed #666EE8;    
    height: 350px;    
    background: #1e9ff200;
    margin: 15px 0;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: 700;
    width:100%;      
  }

  .fileDiv:hover {
    
    background: #1e9ff200;
    
  }
  
  .fileDiv p {    
    font-size: 2rem;
    position: absolute;
    top: 120px;
    left: -3px;
    width: 100%;
    height: 300px;
    color: #666EE8;
    text-align: center;
  }
  .fileDiv:before {
    content: "\e94b";
    font-family: 'feather';
    font-size: 80px;
    position: inherit;    
    align-content: flex-end;
    line-height: 5;
    margin: auto;
    z-index: 1;
    color: #666EE8;
    font-weight: normal;
    -webkit-font-smoothing: antialiased;
    padding: 40%;

  }
</style>
<script>

    function readURL2(input) {   
        if (input.files && input.files[0]) {
          $.each(input.files, function(index, value) {    
            var reader = new FileReader();
            reader.onload = function(e) {              
              $('.filePhotoPlace').prepend('<div class="col-md-6"><img class="img-thumbnail img-fluid showimg" src="'+e.target.result+'" style="display: none;" /></div>');
              $('.showimg').fadeIn('slow');
            };
            reader.readAsDataURL(input.files[index]);            
            // $('.filePhotoPlace').prepend('<input name="photos[]" type="file" value="'+$('#placeimage').val()+'"/>');              
          });            
          $( "#placeimage" ).clone().appendTo( ".filePhotoPlace" );
          $('.filePhotoPlace').find('#placeimage').attr({'name':'uploadphotos[]','id':'','style':'display:none'});          
        }    
    };
    function removeUpload(input) {
        $('.'+input.name+' .file-upload-input').replaceWith($('.'+input.name+' .file-upload-input').clone());
    }
</script>
@endsection


