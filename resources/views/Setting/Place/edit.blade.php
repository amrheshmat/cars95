<!-- language -->
@extends('layouts.app')
  {{-- Dropzone --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/file-uploaders/dropzone.css') }}">
  {{-- End Dropzone --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/js/gallery/photo-swipe/photoswipe.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/js/gallery/photo-swipe/default-skin/default-skin.css') }}">
    
@section('content')
  <div class="row">
    <div class="col-md-8">
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
    </div>

    <div class="col-md-4">
      {!! Form::model($model,['route'=> [$action,$model->id],'class'=>'dropzone','id'=> 'dropzone','method'=>'PUT','role'=>'dropzone','enctype' =>'multipart/form-data' ])!!}
        <div class="fallback">
          <input name="image" type="image" multiple />
        </div>
      {!! Form::close()!!}
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
            <div class="row">
              @foreach($model->images as $image)              
              <div class="col-md-6 col-sm-12">
                {{-- <button type="button" class="btn-float-xs btn-danger reda" style="margin:-10px -11px 0 0;padding: 0px;position: absolute;"><i class="fa fa-remove"></i></button> --}}
                <a href="{{URL::route(class_basename($model).'.destroy',$image->id)}}" class="reda"><i class="fa fa-trash fa-2x text-danger" style="margin: 4px 9px 0 0;position: absolute;opacity: 0.5;"></i></a>
                <div>
                  <figure itemprop="associatedMedia">                
                    <a href="{{url($image->image)}}" itemprop="contentUrl" data-size="1200x800">
                        <img class="img-thumbnail img-fluid" src="{{url($image->image)}}" itemprop="thumbnail" alt="Image description" />
                      </a>
                  </figure>
                </div>
              </div>
              @endforeach
              
            </div>
          </div>
          <!--/ Image grid -->
          <!-- Root element of PhotoSwipe. Must have class pswp. -->
          <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <!-- Background of PhotoSwipe. 
            It's a separate element as animating opacity is faster than rgba(). -->
            <div class="pswp__bg"></div>
            <!-- Slides wrapper with overflow:hidden. -->
            <div class="pswp__scroll-wrap">
              <!-- Container that holds slides. 
              PhotoSwipe keeps only 3 of them in the DOM to save memory.
              Don't modify these 3 pswp__item elements, data is added later on. -->
              <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
              </div>
              <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
              <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                  <!--  Controls are self-explanatory. Order can be changed. -->
                  <div class="pswp__counter"></div>
                  <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                  <button class="pswp__button pswp__button--share" title="Share"></button>
                  <button class="pswp__button pswp__button--fs"
                    title="Toggle fullscreen"></button>
                  <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                  <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                  <!-- element will get class pswp__preloader-active when preloader is running -->
                  <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                  <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left"
                  title="Previous (arrow left)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>
                <div class="pswp__caption">
                  <div class="pswp__caption__center"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--/ PhotoSwipe -->
      </section>
    </div>

    
  </div>

  <script type="text/javascript">
    $( document ).ready(function() {  $(function () { $('select').select2();})});
    $(document).on('click','.reda',function(e){
      e.preventDefault();
      var me      = $(this);
      var route 	= $(this).attr('href');
      var token   = "{{ csrf_token() }}";
      $.confirm({
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
                    data    : {_method: 'delete', _token :token,photoId:token},
                    dataType:'json',           
                    success : function(data){
                      me.parent().fadeOut(800, function() { $(this).remove(); });    
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
                close: function () {btnClass: 'btn btn-blue'},		            
              },
          },
      });
    });


  </script>
  <script src="{{asset('/app-assets/vendors/js/gallery/photo-swipe/photoswipe.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('/app-assets/vendors/js/gallery/photo-swipe/photoswipe-ui-default.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('/app-assets/js/scripts/gallery/photo-swipe/photoswipe-script.js')}}" type="text/javascript"></script>
  <script src="{{asset('/app-assets/vendors/js/extensions/dropzone.min.js')}}" type="text/javascript"></script>


    
@endsection

