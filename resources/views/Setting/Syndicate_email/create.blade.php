<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="from-actions-top-left"> @lang('neqabty.createemail') </h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>            
            </ul>
        </div>
    </div>
   <div class="card-content collpase show">
        <div class="card-body">
            <div class="insertemail">
            @if(!empty(old('email')))
                @for ($x = 0; $x < count(old('email')); $x++)
                    <div class="form-group">    
                        <div class="input-group @if($errors->has('email.'.$x)) has-error @endif" title="@if($errors->has('email.'.$x)) {{$errors->first('email.'.$x)}} @endif">
                            <input name="email[]" placeholder="@lang('neqabty.emailaddress')" id="email-{{$x}}" value="{{ old('email.'.$x) }}" type="email" class="email form-control" required="required">
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
              <input type="text" class="email form-control" id="emailAddress" name="addemail" placeholder="@lang('neqabty.AddEmail')" >
              <div class="input-group-append">
                <button type="button" id="AddEmail" data-route="" class="btn btn-success" > <i class="fa fa-plus"></i></strong>
                </div>
              </div>
              <label class="email-alert-erro text-danger"></label>
            </div>
    </div>
</div>
<script type="text/javascript">
  $( document ).ready( function() { 
    var email      =  "{{@count(old('email'))}}" + 1;
    $('#AddEmail').on('click', function() {
      var emailAddress = $('#emailAddress').val();
      var Email  	= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      if (Email.test(emailAddress)) {    
        $('.insertemail').prepend('<div class="form-group"><div class="input-group"><input name="email[]" placeholder="@lang("neqabty.emailAddress")" value="'+emailAddress+'" id="email-'+ email +'" type="email" class="email form-control"><span class="input-group-append"><button type="button" class="btn btn-danger btn-flat input-sm" onclick="$(this).parent().parent().remove();"><i class="fa fa-remove"></i></button></span></div></div>');
        email++;
        $('#emailAddress').val('');
        $('.email-alert-erro').val('');
      } else {
        $('#emailAddress').parent().addClass('has-error');
        $('.email-alert-erro').text('@lang("neqabty.emailalerterror")');
        return false;
      }


      return false;
    });
  });
</script>
