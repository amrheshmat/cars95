@extends('carslayouts.app')

@section('content')
                <div class="section-title text-center">
                    <h3>New Cars </h3>
                    <p>Maecenas sit amet tristique turpis. Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. Donec consectetur accumsan arcu, sit amet fringilla ex ultricies.</p>
                </div><!-- end title -->
<div class="case-top clearfix">
                    <div class="pull-left hidden-xs">
                    </div><!-- end col -->
<div class="pull-right">
                        <div class="dropdown portfolio-filter">
                            <button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown">Product Filter
                            <span class="fa fa-angle-down"></span></button>
                            <ul class="dropdown-menu">
                              <li><a class="active" href="#" data-filter="*">All Projects</a></li>
                            @foreach($cars as $car)
                                <li><a class="" href="#" data-filter=".{{$car->car_type}}">{{$car->car_type}}</a></li>
                            @endforeach
                            </ul>
                        </div><!-- end dropdown -->
                    </div><!-- end col -->
                </div><!-- end row -->
<div class="container">

<div class="row">
                    <div class="col-md-12">
                        <div class="portfolio row with-desc">
                        @foreach($cars as $car)
                            <div class="post-media pitem item-w1 item-h1 {{$car->car_type}}">
                                <div class="entry">
                                    <img src="{{$car->car_img}}" alt="" class="img-responsive">
                                    
                                </div><!-- end entry -->
                                
                                <div class="item-desc">
                                    <h4><a href="#">{{$car->car_name}}</a></h4>
                                    <p>{{$car->car_desc}}</p>
                                    <div style="margin-left: 25%;">
                                <a style="border-radius:10px;width: 60px;text-align: center;padding: 9px;" class=" btn btn-primary" href="{{url('buyItem/').'/'.$car->id}}">
                                    Buy
                                    </a>
                                    <a style="border-radius:10px;width: 60px;text-align: center;padding: 9px;" class=" btn btn-primary" href="{{url('viewItem/').'/'.$car->id}}">
                                    View
                                    </a>
                                 </div>
                                </div>
                                
                            </div><!-- end post-media -->
                     
                        @endforeach
                        </div><!-- end row -->
                    </div><!-- end col -->
                </div><!-- end row -->
    {{ $cars->links() }}
</div>
@endsection