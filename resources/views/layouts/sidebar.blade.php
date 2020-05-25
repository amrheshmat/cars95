@php 
  $Permission   = \Ultraware\Roles\Models\Permission::where('sidebar','Y')->orderBy('group_id')->get()->toArray();
  $ul           = array();
  $group_id     = array_unique(array_column($Permission, 'group_id'));
  $li           = \Ultraware\Roles\Models\Permission::whereIn('group_id',$group_id)->where('sidebar','Y')->orderBy('order_items')->get();
@endphp


          

  <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="{{url('/Dashboard')}}"><i class="fa fa-home"></i><span class="menu-title" data-i18n="nav.dash.main">@lang('neqabty.controlPanel')</span></a></li>
        @foreach ($Permission as $sidebar)
          @permission($sidebar['slug'])
              @if (in_array($sidebar['group_id'],$ul))
              @else
                @php $ul[$sidebar['group_id']] = $sidebar['group_id']; @endphp
                <li class="nav-item" id="treeview-{{$sidebar['group_id']}}">
                    <a href="#"><i class="{{$sidebar['group_icon']}}"></i><span class="menu-title" data-i18n="nav.cards.main">@lang('neqabty.'.$sidebar['group_name'])</span></a>
                    <ul class="menu-content" id="treeview-menu-{{$sidebar['group_id']}}">
                      @foreach ($li as $subsidebar)
                        @if($subsidebar->group_id == $sidebar['group_id'])
                          @permission($subsidebar->slug)
                          <li class="nav-item" id="active-id-{{$subsidebar->id}}"><a class="menu-item" href="{{route($subsidebar->name)}}" data-i18n="nav.{!! $subsidebar->title !!}"> <i class="{{$subsidebar->icon}}"> </i>  @lang('neqabty.'.$subsidebar->title) </a> </li>
                          @if (strpos(strtolower(Route::current()->getName()), strtolower($subsidebar->model)) !== false)                          
                            <script>
                              $("#treeview-{{$sidebar['group_id']}}").toggleClass("open");                              
                              $("#active-id-{{$subsidebar->id}}").toggleClass("active");
                            </script>
                            @endif
                          @endpermission
                        @endif
                      @endforeach
                    </ul>
                </li>
              @endif
          @endpermission
        @endforeach
      </ul>
    </div>
    
  </div>







        


  