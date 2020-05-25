<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="from-actions-top-left"> @lang('neqabty.editphone') </h4>
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
                @foreach ($model->phones as $phone)
                    <div class="form-group" id="phone-{!! $phone->id !!}">    
                        <div class="input-group">
                            <span id="phone-{{$phone->id}}" class="form-control" style="background-color:#607d8b21">{{ $phone->phone}}</span>
                            <span class="input-group-append" onClick="removePhoneData(this)" data-phone="{!! $phone->phone !!}" data-id="{!! $phone->id !!}" data-href="{{route('Syndicate.destroy',$phone->id)}}">
                                <button type="button" class="btn btn-danger btn-flat input-sm" ><i class="fa fa-remove"></i></button></span>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr/>
            <div class="input-group">
                <input type="text" class="number form-control" id="phoneNumber" name="addphone" placeholder="@lang('neqabty.AddPhone')" data-inputmask='"mask": "(9999) 999-9999"' data-mask>
                <div class="input-group-append">
                    <button type="button"  onclick="createPhone();" class="btn btn-success" > <i class="fa fa-plus"></i></strong>
                </div>
            </div>
            <label class="phone-alert-error text-danger"></label>
        </div>
    </div>
</div>

<script type="text/javascript">
  
    function createPhone(){
        var number = $('#phoneNumber').val();
        $( ".phone-alert-error" ).empty();
        var phone = parseInt(number.replace(/[^0-9]/g, ''), 10);
        if (isNaN(phone)) {return false;}
        var _token  = $('input[name=_token]').val();
        var Route   = "{{Route(class_basename($model).'.update',$model->id)}}";        
        $.ajax({
            url: Route,
            method: 'PUT',
            dataType: 'json',
            data: {_token:_token,_method:'PUT',phone:phone},
            success: function (data) {
                $('.insertphone').prepend('<div class="form-group" id="phone-'+data.id+'"><div class="input-group"><span class="form-control" style="background-color:#607d8b21">'+data.phone+'</span><span class="input-group-append" onClick="removePhoneData(this)" data-phone="'+data.phone+'" data-id="'+data.id+'" data-href="{!! url('Syndicate') !!}/'+data.id+'"><button type="button" class="btn btn-danger btn-flat input-sm"><i class="fa fa-remove"></i></button></span></div></div>');
                $('#phoneNumber').val('');
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors.errors, function(index, value) {
                    $( ".phone-alert-error" ).append(value + '<br/>' );                   
                });
            }
        });
        return false;
    };


    function removePhoneData(phone){ 
        var route 	= $(phone).data('href');
        var token   = "{{ csrf_token() }}";   
        $.confirm({
            animation           : 'rotateX',
            closeAnimation      : 'rotateXR',
            title               : '@lang("neqabty.deletephone") #'+ $(phone).data('phone'),
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
                            data    : {_method: 'delete', _token :token,phone:'phone'},
                            dataType:'json',           
                            success : function(data){
                                $('#'+data).fadeOut(800, function() { $(this).remove(); });
                            },
                        });
                    },
                },
                cancel: {
                    text: '@lang("neqabty.cancel")',
                    btnClass: 'btn-info', // multiple classes.
                    close: function () {
                        btnClass: 'btn btn-blue'
                    },
                
                },
            },
        });
        
    }

</script>

