@extends('carslayouts.app')

@section('content')

<div class="container">
    <h1 for="exampleFormControlInput1" style="text-align:center;font-weight:bold; font-family:Poppins,serif">Contact Us</h1>
    <div class="form col-lg-12" style="background-color:#eee;border:1px solid#e2dfdf;border-radius:9px;margin-bottom:70px;padding:10px;">
        <form method="POST" action="/ContactRequest" >
        {{ csrf_field() }}
          <div class="form-group col-lg-8 col-lg-offset-2">
                <label for="exampleFormControlInput1">Full Name </label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="full_name">
            </div>
           <!-- <div class="form-group col-lg-8 col-lg-offset-2">
                <label for="exampleFormControlInput1">Property Type</label>
                <select name="property_type" class="form-control" id="exampleFormControlInput1">
                    <option name="property_type" value="Rent">Rent</option>
                    <option name="property_type" value="Ownership">Ownership</option>
                </select>
            </div>-->
            <div class="form-group col-lg-8 col-lg-offset-2">
                <label for="exampleFormControlInput1">Email</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="email">
            </div>
            <div class="form-group col-lg-8 col-lg-offset-2">
                <label for="exampleFormControlInput1">Phone</label>
                <input type="number" class="form-control" id="exampleFormControlInput1" name="phone">
            </div>
            <div class="form-group col-lg-8 col-lg-offset-2">
                <label for="exampleFormControlInput1">Description</label>
                <textarea type="text" col="3" class="form-control" id="exampleFormControlInput1" name="describtion"></textarea>
            </div>
            
            <div class="form-group col-lg-8 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" style="border-radius:10px;" id="exampleFormControlInput1" name="propertyRequest" value="Send">
            </div>
            
        </form>
    </div>
    <hr style="border:1px dotted #e2dfdf">
    

</div>
@endsection