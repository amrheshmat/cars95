<!-- language -->
@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/js/gallery/photo-swipe/photoswipe.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/js/gallery/photo-swipe/default-skin/default-skin.css') }}">
@section('content')


       <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header" style="background-color: #1e9ff2;  color: white;">
                <h4 class="card-title" style="color: white;font-weight: 900;">فيروس كورونا</h3> 
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content">
               <br>
                <div class="row">
                <div class="table-responsive col-6" >
                  <table class="table">
                     <tbody> 
                        <tr>
                           <td>رقم العضوية</td>
                           <td>{{ $model['OldRefID'] }}</td>
                         </tr>

                        <tr>
                           <td>نوع الاصابه</td>
                           <td>{{ isset($model['type_of_injury']) ? $model['type_of_injury'] : "" }}</td>
                         </tr>                                       
                         <tr>
                           <td>الوظيفه</td>
                           <td>{{ $model['job'] }}</td>
                         </tr>

                         <tr>
                           <td>جهه العمل</td>
                           <td>{{ $model['job_destination'] }}</td>
                         </tr>
                         <tr>
                           <td>جهه العلاج</td>
                           <td>{{ $model['treatment_destination'] }}</td>
                         </tr>
                         <tr>
                           <td>عدد افراد الاسره</td>
                           <td>{{ $model['family_number'] }}</td>
                         </tr>
                         <tr>
                           <td>وصف الضرر</td>
                           <td>{{ $model['desc_of_injury'] }}</td>
                         </tr>
                         
                         <tr>
                           <td>النقابة العامة</td>
                           <td>نقابة المهندسين المصرية</td>
                         </tr>
                         
                     </tbody>
                  </table> 
                  <br>
                </div>

                <div class="table-responsive col-6" >   
                @foreach($docs as $doc)
              <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia">
                
                
                <a href="{{url($doc->doc)}}" itemprop="contentUrl" data-size="480x360">
                    <img class="img-thumbnail img-fluid" src="{{url($doc->doc)}}" itemprop="thumbnail" alt="Image description" />
                </a>
                <button type="button" class="btn-float-xs btn-danger"><i class="la la-remove"></i></button>
              </figure>
              @endforeach 
                    
                    {!! Form::model($model,['route'=> [$action,$model->id],'id'=> class_basename($model),'method'=>'PUT','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
                   
                  <section id="image-gallery" class="card">
        <div class="card-header">
          
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="card-content  collpase show">
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
                    
                    

                  


                    <script>
                      $(document).ready(function(){
                              $("#aprroval_num").show();
                              $("#comment").show();
                      });
                    </script>

                   

                       <div class="uk-width-medium-1-1 parsley-row" id="aprroval_num" style="display:none">
                       <div class="md-input-wrapper"><label for="wizard_fullname">رقم الموافقة<span class="req">*</span></label>
                       <input readonly="readonly" style="text-align:right" type="text" value="{{rand(1,time()) }}" name="approval_number" id="approval_number" class="form-control"><span class="md-input-bar "></span></div><br>
                       </div>


                       <div class="uk-width-medium-1-1 parsley-row" id="comment" style="display:none">
                       <div class="md-input-wrapper"><label for="wizard_fullname">تعليق<span class="req">*</span></label>
                       <textarea style="text-align:right" name="comment" id="comment" required="" class="form-control">
                       {{ $model['comment'] }}
                       </textarea>
                       </div>
                        <br>

                        @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif
                        <br>
                        <button  type="submit" class="btn btn-success">إرسال</button>
                        <a  class="btn btn-red" href="main-syndicates">الغاء</a>
                                                
              </form>


                </div>



                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div> 




  <script type="text/javascript">
    $( document ).ready(function() {  $(function () { $('select').select2();})});
  </script>
  <script src="{{asset('/app-assets/vendors/js/gallery/photo-swipe/photoswipe.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('/app-assets/vendors/js/gallery/photo-swipe/photoswipe-ui-default.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('/app-assets/js/scripts/gallery/photo-swipe/photoswipe-script.js')}}" type="text/javascript"></script>
@endsection
