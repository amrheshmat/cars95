<!-- language -->
@extends('layouts.app')
@section('content')
  <section id="solid-alerts-with-icons-arrows">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-content collapse show">
            <div class="card-body">
              <p>@lang('neqabty.notallowtoaddnew')</p>
                <div class="col-md-12">
                  <h6>@lang('neqabty.alert')</h6>
                  <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-frown-o"></i></span>                        
                    @lang('neqabty.wearesorryyouhavetogoback') <a href="{{route('Setting.index')}}" class="alert-link">@lang('neqabty.back')</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


