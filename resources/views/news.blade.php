@extends('carslayouts.app')

@section('content')
<div class="container">
@foreach($news as $new)
    <div class="col-lg-4 col-md-12" style="overflow: hidden;height: 600px;margin-bottom:40px;">
        <div class="blog-box" style="height: 85%;">
            <div class="post-media">
                <a href="#"><img src="images{{$new->img}}" alt="" class="img-responsive"></a>
            </div><!-- end media -->
            <div class="blog-desc">
                <h4><a href="#"> {{$new->title}}</a></h4>
                <p>
                   {{$strcut = substr($new->desc,0,250)}} 
                  {{ $strcut }}</p>
            </div><!-- end blog-desc -->

            <div class="post-meta">
                <ul class="list-inline">
                    <li><a href="#">{{$new->created_at}}</a></li>
                </ul>
            </div><!-- end post-meta -->
        </div><!-- end blog -->
    </div><!-- end col -->
    @endforeach
    {{ $news->links() }}
</div>
@endsection