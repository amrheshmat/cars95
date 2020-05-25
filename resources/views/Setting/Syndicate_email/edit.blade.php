<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="from-actions-top-left"> @lang('neqabty.editemail') </h4>
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
                @foreach ($model->emails as $email)
                    <div class="form-group" id="email-{!! $email->id !!}">    
                        <div class="input-group">
                            <span id="email-{{$email->id}}" class="form-control" style="background-color:#607d8b21">{{ $email->email}}</span>
                            <span class="input-group-append" onClick="removeEmailData(this)" data-email="{!! $email->email !!}" data-id="{!! $email->id !!}" data-href="{{route('Syndicate.destroy',$email->id)}}">
                                <button type="button" class="btn btn-danger btn-flat input-sm" ><i class="fa fa-remove"></i></button>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr/>
            <div class="input-group">
                <input type="text" class="number form-control" id="emailAddress" name="addemail" placeholder="@lang('neqabty.AddEmail')">
                <div class="input-group-append">
                    <button type="button"  onclick="createEmail();" class="btn btn-success" > <i class="fa fa-plus"></i></strong>
                </div>
            </div>
            <label class="email-alert-error text-danger"></label>
        </div>
    </div>
</div>

<script type="text/javascript">
  
    function createEmail(){
        $( ".email-alert-error" ).empty();
        var email = $('#emailAddress').val();
        var Email  	= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (Email.test(email)) { 
            var _token  = $('input[name=_token]').val();   
            var Route   = "{{Route(class_basename($model).'.update',$model->id)}}";
            $.ajax({
                url: Route,
                method: 'PUT',
                dataType: 'json',
                data: {_token:_token,_method:'PUT',email:email},
                success: function (data) {
                    $('.insertemail').prepend('<div class="form-group" id="email-'+data.id+'"><div class="input-group"><span class="form-control" style="background-color:#607d8b21">'+data.email+'</span><span class="input-group-append" onClick="removeEmailData(this)" data-email="'+data.email+'" data-id="'+data.id+'" data-href="{!! url('Syndicate') !!}/'+data.id+'"><button type="button" class="btn btn-danger btn-flat input-sm"><i class="fa fa-remove"></i></button></span></div></div>');
                    $('#emailAddress').val('');
                },
                error: function (data) {
                    var errors = $.parseJSON(data.responseText);                
                    
                    $.each(errors.errors, function(index, value) {
                        $( ".email-alert-error" ).append(value + '<br/>' );                   
                    });
                }
            });
            return false;
        } 
        $('#emailAddress').parent().addClass('has-error');
        $('.email-alert-error').text('@lang("neqabty.emailalerterror")');
        return false;

    };


    function removeEmailData(email){ 
        var route 	= $(email).data('href');
        var token   = "{{ csrf_token() }}";
        

        


        
        
        
        $.confirm({
            animation           : 'rotateX',
            closeAnimation      : 'rotateXR',
            title               : '@lang("neqabty.deletemail") #'+ $(email).data('email'),
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
                            data    : {_method: 'delete', _token :token,email:'email'},
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

