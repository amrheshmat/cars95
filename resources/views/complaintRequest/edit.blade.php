<!-- language -->
@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/js/gallery/photo-swipe/photoswipe.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/js/gallery/photo-swipe/default-skin/default-skin.css') }}">
@section('content')
<div class="row">
<div class="col-xl-12 col-md-12">
  <div class="card">
    <div class="card-content">
      <div class="media align-items-stretch bg-warning text-white rounded">
        <div class="bg-warning bg-darken-2 p-2 media-middle">
          <i class="fa fa-plane font-large-2 text-white"></i>
        </div>
        <div class="media-body p-2">
          <h4 class="text-white">{{$trip->trip_title}}</h4>
          <span>تاريخ الرحلة : {{$model['regiment_date']}}</span>
        </div>
        <div class="media-right p-2 media-middle">
          <h1 class="text-white">نوع الحجز : {{$model['housing_type']}}</h1>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="row">
            <div class="col-md-8 col-sm-12">
              <div class="card box-shadow-0 border-info">
                <div class="card-header card-head-inverse bg-info">
                  <h4 class="card-title text-white">بيانات المهندس</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                      <div class="container">
                           <div class="row">
                               <div class="col"><p><span class="blue">الأسم :</span> {{$model['name']}} </p></div>
                               <div class="col"><P><span class="blue">تاريخ الفوج :</span> {{ Carbon\Carbon::parse($model['created_at'])->format('d/m/Y ') }}  </P></div>
                           </div>
                           <div class="row">
                               <div class="col"><p><span class="blue">البريد الالكترونى :</span> {{ isset($model['email']) && $model['email'] !='' ? $model['email'] : "لا يوجد" }} </p></div>
                               <div class="col"><p><span class="blue">الموبايل :</span> {{ $model['phone'] }} </p></div>
                           </div>
                           <hr>
                           <div class="row">
                               <div class="col"><p><span class="blue">نوع الحجز :</span>  {{$model['housing_type']}} </p></div>                               
                           </div>
                           <div class="row">
                               <div class="col"><p><span class="blue">عدد الاطفال :</span> {{ $model['num_child'] }} </p></div>                             
                           </div>
                           <div class="row">
                               <div class="col"><p><span class="blue">اعمار الاطفال :</span> {{ $model['ages'] }} </p></div>                             
                           </div>
                           <hr>
                           <h5>تفاصيل الفوج</h5>
                           <div class="row">
                               @if($regiment->hotel_one_person != 0)<div class="col"><p><span class="blue">فردي :</span>  {{ $regiment->hotel_one_person }}    جنيهاً</p></div> @endif
                               @if($regiment->hotel_tow_person != 0)<div class="col"><p><span class="blue">ثنائي :</span> {{ $regiment->hotel_tow_person }}   جنيهاً</p></div>  @endif
                               @if($regiment->hotel_three_person != 0)<div class="col"><p><span class="blue">ثلاثي :</span>  {{ $regiment->hotel_three_person }} جنيهاً </p></div> @endif
                           </div>
                           <div class="row">
                               @if($regiment->apartment_oneRoom_price != 0)<div class="col"><p><span class="blue">غرفة واحدة :</span>  {{ $regiment->apartment_oneRoom_price }}    جنيهاً</p></div>@endif
                               @if($regiment->apartment_towRooms_price != 0)<div class="col"><p><span class="blue">غرفتين :</span> {{ $regiment->apartment_towRooms_price }}   جنيهاً</p></div>@endif
                               @if($regiment->apartment_studio_price != 0)<div class="col"><p><span class="blue">استديو :</span>  {{ $regiment->apartment_studio_price }} جنيهاً </p></div>@endif
                           </div>
                          
                           <div class="row">
                           @if($regiment->apartment_view_price != 0)<div class="col"><p><span class="blue">شقة مطلة :</span>  {{ $regiment->apartment_view_price }}    جنيهاً</p></div>   @endif                          
                           @if($regiment->apartment_side_price != 0)<div class="col"><p><span class="blue">شقة جانبية :</span> {{ $regiment->apartment_side_price }}   جنيهاً</p></div>  @endif                           
                           </div>

                           <hr>                           
                           <div class="row">
                               <div class="col"><p><span class="blue">سعر الطفل :</span>  {{ $regiment->child_price }}    جنيهاً</p></div>                             
                           </div>
                           @if($regiment->villa_price != 0)
                           <div class="row">
                               <div class="col"><p><span class="blue">شاليه :</span>  {{ $regiment->villa_price }}    جنيهاً</p></div>                             
                           </div>
                           @endif
                      </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-12">
            <div class="card box-shadow-0 border-info">
                <div class="card-header card-head-inverse bg-info">
                  <h4 class="card-title text-white">الطلب</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>

                <div class="card-content collapse show">
                          <div class="card-content">
                            <div class="card-body">
                              <h4 class="card-title">المستندات</h4>
                                  @foreach($docs as $doc)
                                  <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia">
                                    <a href="{{url($doc->doc)}}" itemprop="contentUrl" data-size="480x360">
                                        <img class="img-thumbnail img-fluid" src="{{url($doc->doc)}}" itemprop="thumbnail" alt="Image description" />
                                    </a>
                                    <button type="button" class="btn-float-xs btn-danger"><i class="la la-remove"></i></button>
                                  </figure>
                                  @endforeach
                            </div>
                            <hr>
                            {!! Form::model($model,['route'=> [$action,$model->id],'method'=>'PUT','role'=>'form','data-toggle'=>'validator','enctype' =>'multipart/form-data' ])!!}
                            <div class="uk-width-medium-1-1 parsley-row">
                            <div class="md-input-wrapper">
                              <select style="text-align:right" name="status" id="status"   class="form-control">                              
                                  <option>إختر حالة الطلب</option>
                                  <option value="1" {{ $model['status']==1 ? "selected" : "" }} >قبول الطلب</option>
                                  <option value="2" {{ $model['status']==2 ? "selected" : "" }} >رفض الطلب</option>
                              </select>
                            <span class="md-input-bar "></span></div><br>
                           </div>
                    
                            
                    @if($model['status'] == 1)
                       <table class="table">
                         <tr>
                           <td>رقم الموافقة</td>
                           <td>{{ $model['approval_number'] }}</td>
                           
                         </tr>
                         <tr>
                           <td>صورة الموافقة </td>
                           <td><img src="{{url($model->approval_image)}}" width="50%"></td>
                         </tr>
                         <tr>
                           <td>تعليق</td>
                           <td>{{ $model['comment'] }}</td>
                         </tr>
                       </table>
                    @elseif($model['status'] == 2)
                    <table class="table">                        
                         <tr>
                           <td>سبب الرفض</td>
                           <td>{{ $model['comment'] }}</td>
                         </tr>
                       </table>
                    @endif

                    <script>
                      $(document).ready(function(){
                          $("#status").change(function()
                          {
                            if($("#status").val() ==1)
                            {
                              $("#aprroval_num").show();
                              $("#approval_image").show();
                              $("#comment").show();
                            }
                            if($("#status").val() ==2)
                            {
                              $("#aprroval_num").hide();
                              $("#approval_image").hide();
                              $("#comment").show();
                            }
                            
                          });
                      });
                    </script>

                   

                       <div class="uk-width-medium-1-1 parsley-row" id="aprroval_num" style="display:none">
                       <div class="md-input-wrapper"><label for="wizard_fullname">رقم الموافقة<span class="req">*</span></label>
                       <input style="text-align:right" type="text" value="{{ $model['approval_number'] }}" name="approval_number" id="approval_number" class="form-control"><span class="md-input-bar "></span></div><br>
                       </div>

                       

                        
                       <div class="uk-width-medium-1-1 parsley-row" id="approval_image" style="display:none">
                           <div class="form-control"><label for="wizard_fullname">صورة الموافقة</span></label><br><br>
                            {!! Form::file('approval_image', array('class' => 'form-control')) !!}
                        </div>
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
            

      </section>
                    
                    

                   



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

