<!-- language -->
@extends('layouts.app')
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/file-uploaders/dropzone.min.css') }}"> --}}
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/file-uploaders/dropzone.css') }}"> --}}
  <!-- END VENDOR CSS-->
@section('content')
  @php 
    $roles      = Ultraware\Roles\Models\Role::pluck('slug','id')->toArray();
    /*  $Callcenter_belongsToMany = App\Callcenter::pluck('name','id')->toArray();*/
    $Ip_belongsToMany         = App\Ip::pluck('ip','id')->toArray();
    /* $callcenter_id = App\Callcenter::pluck('name','id')->toArray(); */
  @endphp
  <section id="form-action-layouts">
    <div class="row match-height">
      <div class="col-md-12">
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
              {!! Form::model($model,['route'=> $action,'id'=> class_basename($model),'method'=>'POST','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
                <div class="form-body" id="formbody">
                  @include(Admin.'.layouts.create')
                </div>
                <div class="form-actions right">
                  <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-floppy-o"></i> @lang("neqabty.submit") </button>
                  <button type="button" class="btn btn-danger mr-1" onclick="history.go(0);"> <i class="fa fa-times"></i> @lang("neqabty.cancel") </button>
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
  </script>


<style>
  .check_picture {
    border: 2px dashed #0087F7;
    /* width: 200px; */
    margin: 0;
    color: #1e9ff2;
    background: #1e9ff200;
    padding: 5px;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: 700;
    margin-right: -8px;
    /*
    width: 100%;
    margin: 0;
    color: #fff;
    background: #1FB264;
    border: none;
    padding: 10px;
    border-radius: 4px;
    border-bottom: 4px solid #15824B;
    transition: all .2s ease;
    outline: none;
    text-transform: uppercase;
    font-weight: 700;
    */
  }

  .check_picture:hover {
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

  .check_picture:before {
    content: "@lang('neqabty.insertphoto')";
  }
  .check_picture > input {
    position: absolute;
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    outline: none;
    opacity: 0;
    cursor: pointer;
  }
  #text_picture{
    float: left;
  }
</style>
<script>
  $('#picture').change(function() {
      var input  = $('#picture');
      $('#text_picture').html('<div style="float:left">'+input.val()+'</div>');
  });
</script>

  {{-- <style>
    .file-upload-btn {
      border: 2px dashed #0087F7;
      width: 200px;
      margin: 0;
      color: #1e9ff2;
      background: #1e9ff200;
      padding: 5px;
      border-radius: 4px;
      text-transform: uppercase;
      font-weight: 700;
      margin-right: -8px;
      /*
      width: 100%;
      margin: 0;
      color: #fff;
      background: #1FB264;
      border: none;
      padding: 10px;
      border-radius: 4px;
      border-bottom: 4px solid #15824B;
      transition: all .2s ease;
      outline: none;
      text-transform: uppercase;
      font-weight: 700;
      */
    }

    .file-upload-btn:hover {
      background: #0087F7;
      /* border: 2px dashed #fff; */
      color: #ffffff;
      transition: all .2s ease;
      cursor: pointer;
    }

    .file-upload-btn:active {
      border: 0;
    }





    .file-upload-content {
      display: none;    
    }

    .file-upload-input {
      position: absolute;
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      outline: none;
      opacity: 0;
      cursor: pointer;
    }

    .image-upload-wrap {
      /*
      margin-top: 20px;
      border: 4px dashed #1FB264;
      position: relative;
      */
    }

    .image-dropping,
    .image-upload-wrap:hover {
      /*
      background-color: #1FB264;
      border: 4px dashed #ffffff;
      */
    }

    .image-title-wrap {
      padding-top:15px;
      color: #222;
    }
    .image-title-wrap > button{
      width: 200px;
    }
    .drag-text {
      text-align: center;
    }

    .drag-text h3 {
      font-weight: 100;
      text-transform: uppercase;
      color: #15824B;
      padding: 60px 0;
    }

    .file-upload-image {
      max-height: 200px;
      max-width: 200px;
      margin: 0 -9px -16px 0;
      padding: 1px 8px;
    }

    .remove-image {
      width: 200px;
      margin: 0;
      color: #fff;
      background: #cd4535;
      border: none;
      padding: 10px;
      border-radius: 4px;
      border-bottom: 4px solid #b02818;
      transition: all .2s ease;
      outline: none;
      text-transform: uppercase;
      font-weight: 700;
    }

    .remove-image:hover {
      background: #c13b2a;
      color: #ffffff;
      transition: all .2s ease;
      cursor: pointer;
    }

    .remove-image:active {
      border: 0;
      transition: all .2s ease;
    }
  </style> --}}


  {{-- <div class="row">
    <div class="col-md-6 text-center">
        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
        <div class="image-upload-wrap"> <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" /> </div>
        <div class="file-upload-content">
          <img class="file-upload-image" src="#" alt="your image" />
          <div class="image-title-wrap">
            <button type="button" onclick="removeUpload()" class="btn btn-danger btn-min-width box-shadow-5 mr-1 mb-1">  <i class="fa fa-trash"></i></button>
          </div>
        </div>
      
    </div>
    <div class="col-md-6 text-center">
        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
        <div class="image-upload-wrap"> <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" /> </div>
        <div class="file-upload-content">
          <img class="file-upload-image" src="#" alt="your image" />
          <div class="image-title-wrap">
            <button type="button" onclick="removeUpload()" class="btn btn-danger btn-min-width box-shadow-5 mr-1 mb-1">  <i class="fa fa-trash"></i></button>
          </div>
        </div>
    </div>
  </div> --}}
  {{-- <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('.image-upload-wrap').hide();
          $('.file-upload-image').attr('src', e.target.result);
          console.log(e.target.result);
          $('.file-upload-content').show();
          $('.image-title').html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        removeUpload();
      }
    }
    function removeUpload() {
      $('.file-upload-input').replaceWith($('.file-upload-input').clone());
      $('.file-upload-content').hide();
      $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
  </script> --}}
@endsection


