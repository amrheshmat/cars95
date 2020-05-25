{!! Form::model('User',['route'=> ['User.changePasswordPost'],'id'=> 'changePasswordPost','method'=>'POST','enctype' =>'multipart/form-data','onsubmit'=>'return submitForm("changePasswordPost")' ])!!}
	<div class="box box-primary">
		<div class="box-body box-profile">
			<img class="profile-user-img img-responsive img-circle" src="{{url(Auth::User()->picture)}}" alt="User profile picture">
			<h3 class="profile-username text-center"><u>{{Auth::User()->name}}</u></h3>
			
	      	<hr/>
				<div class="input-group">
			        <span data-inputid="current_password" class="input-group-addon passwordShowHide"><i class="fa fa-eye-slash"></i></span>
			        <input type="password" class="form-control" name="current_password" id="current_password" placeholder="current password">
		      	</div>
		      	<p></p>
		      	<div class="input-group">
			        <span data-inputid="password" class="input-group-addon passwordShowHide"><i class="fa fa-eye-slash"></i></span>
			        <input type="password" class="form-control"  name="password" id="password" placeholder="New Password">
		      	</div>
		      	<p></p>
		      	<div class="input-group">
			        <span data-inputid="password_confirmation"  class="input-group-addon passwordShowHide"><i class="fa fa-eye-slash"></i></span>
			        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password ">
		      	</div>
		</div>
		<!-- /.box-body -->
	</div>	
	<div class="col-md-4 col-md-push-8">
		<button type="submit" id="submit" class="btn btn-primary btn-block">Submit</button>
	</div>
{!! Form::close()!!}

<script>
	$( document ).ready(function() { 
		$(document).on('click','.passwordShowHide',function(e) {
			$(this).find('i').toggleClass('fa-eye fa-eye-slash');
			var inputid = $(this).data('inputid');
			var x = document.getElementById(inputid);
			if (x.type === "password") {
		        x.type = "text";
		    } else {
		        x.type = "password";
		    }
			
        });
  	});
  	 function submitForm(formName){
  	 	var _token = $('meta[name="csrf-token"]').attr('content');
        var form      = $('#'+formName);
        var dataString  = form.serialize();
        var formAction  = form.attr('action');
        form.find("button[type='submit']").prop('disabled',true);
  		$.ajax({
          type    : "POST",
          url     : formAction,
          data    : dataString,
          dataType:'json',
          success : function(data){
          	$('.jconfirm').remove();
          	$.alert({
                type      : 'green',
                title     : 'success',
                icon      : 'fa fa-check',
                theme     : 'modern',
                content   : data,
                closeIcon : true,
      //           buttons: {
      //             confirm: {
      //               text  : 'logout',
      //               btnClass: 'btn-blue',
      //               action: function () {
      //               	$('.jconfirm').remove();
      // 					//$.ajax({
						// //     url		: 'logout',
			   // //        		type    : "POST",
						// //     data: {_token:_token,_method:'post'},
						// //     success: function(msg) {
						// // 		 window.setTimeout(function(){location.reload()},3000)       	
						// //     }  
						// // });
      //               }
      //             },
      //             cancel: {
      //               text: 'CLOSE',
      //               action: function () {
      //               	$('.jconfirm').remove();
      //               }
      //             }
      //           }
              });


         
          	

            

			

            return false;
          },
          error : function(response){
            var JSONError = '';
            var counter = 0;
            $.each(response.responseJSON.errors, function(index, value) {
              counter++
                // index =  index.replace("_", " ");JSONError += '<i class="fa fa-dot-circle-o text-red"></i> '+ counter index.toUpperCase()   value +'<br/>';
                index =  index.replace("_", " ");JSONError += '<i class="fa fa-dot-circle-o text-red"></i> '+ value +'<br/>';
            });
            $.alert({
                type: 'red',
                columnClass: 'col-md-6 col-md-push-3 col-sm-6',
                title: response.responseJSON.message,content: JSONError,
            });
            form.find("button[type='submit']").prop('disabled',false);        
            return false;
          },
        },"json");
        
        return false;
      }
</script>
