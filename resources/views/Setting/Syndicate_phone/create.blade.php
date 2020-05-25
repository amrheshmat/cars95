<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="from-actions-top-left"> @lang('neqabty.createphone') </h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>            
            </ul>
        </div>
    </div>
    <div class="card-content collpase show">
        <div class="card-body">
            <div class="insertphone">
            @if(!empty(old('phone')))
                @for ($x = 0; $x < count(old('phone')); $x++)
                    <div class="form-group">    
                        <div class="input-group @if($errors->has('phone.'.$x)) has-error @endif" title="@if($errors->has('phone.'.$x)) {{$errors->first('phone.'.$x)}} @endif">
                            <input name="phone[]" placeholder="Phone Number" id="phone-{{$x}}" value="{{ old('phone.'.$x) }}" type="text" class="number form-control" maxlength="12" required="required">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-danger btn-flat input-sm" onclick="$(this).parent().parent().remove();"><i class="fa fa-remove"></i></button>
                            </span>
                        </div>
                    </div>
                @endfor
            @endif    
            </div>
            <hr/>
            <div class="input-group">
                <input type="text" class="number form-control" id="phoneNumber" name="addphone" placeholder="@lang('neqabty.AddPhone')" data-inputmask='"mask": "(9999) 999-9999"' data-mask>
                <div class="input-group-append">
                    <button type="button" id="AddPhone" data-route="" class="btn btn-success" > <i class="fa fa-plus"></i></strong>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  
  $( document ).ready( function() { 
    $("#phoneNumber").on('keyup', function(event) {
      if (event.keyCode === 13) {
        event.preventDefault();
        $("#AddPhone").click();
      }
    });
    //Add Phone
    var phone      =  "{{@count(old('phone'))}}" + 1;
    $('#AddPhone').on('click', function() {
      var number = $('#phoneNumber').val();
      var phoneNumber = parseInt(number.replace(/[^0-9]/g, ''), 10);
      if (isNaN(phoneNumber)) {return false;}
      $('.insertphone').prepend('<div class="form-group"><div class="input-group"><input name="phone[]" placeholder="@lang("neqabty.phonenumber")" value="'+phoneNumber+'" id="phone-'+ phone +'" type="text" class="number form-control" maxlength="12" required="required"><span class="input-group-append"><button type="button" class="btn btn-danger btn-flat input-sm" onclick="$(this).parent().parent().remove();"><i class="fa fa-remove"></i></button></span></div></div>');
      phone++;
      $('#phoneNumber').val('');
      return false;
    });
  });
</script>
