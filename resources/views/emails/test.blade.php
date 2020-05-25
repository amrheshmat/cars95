@extends('layouts.blank')
@section('content')
<div style="display: inline-block; background: none repeat scroll 0px 0px; border: medium none; box-shadow: 0px 0px 2px 0px #cccccc; line-height: 21px; width: 100%;">
<div style="display: inline-block; background: none repeat scroll 0px 0px; border: medium none; box-shadow: 0px 0px 2px 0px #cccccc; line-height: 21px; width: 100%; text-align: center;">

	
	<img src='{{Cloudder::show("Agarley/agarlylogo", array("sign_url"=>true))}}'>

</div>
</div>
<div style="display: inline-block; background: none repeat scroll 0px 0px; border: medium none; box-shadow: 0px 0px 2px 0px #cccccc; line-height: 21px; width: 100%; text-align: center;">
<h3><span style="font-size: x-large;">Hello <label style="padding: 0 0 0 2px;">{{$data['model']->firstname}}</label></span></h3>
</div>
<div style="display: inline-block; background: none repeat scroll 0px 0px; border: medium none; box-shadow: 0px 0px 2px 0px #cccccc; line-height: 21px; width: 100%; text-align: center;">
<p><span style="font-size: large;">Congratulations, Your Account was verified successively.</span></p>
</div>
<div style="display: inline-block; background: none repeat scroll 0px 0px; border: medium none; box-shadow: 0px 0px 2px 0px #cccccc; line-height: 21px; width: 100%;">
<p><span style="font-size: medium;">You can update your account information from here: <a href="https://www.agarly.com/user?page=profile">your profile</a></span>

<br /><span style="font-size: medium;">For listing your space please visit this link : <a href="https://www.agarly.com/listspace">( List your space section )</a></span></p>
<p><span style="font-size: medium;">For more inquiries, please contact us.</span></p>
<h3 style="text-align: center;"><span style="font-size: x-large;">Thanks</span><br /><span style="font-size: x-large;">Agarly Team</span></h3>
</div>

          <p></p>

    @endsection