<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset(Auth::user()->picture) }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form" action="{{ route('Search') }}">
        <div class="input-group">
          <input name="search" type="text" class="form-control" id="navbar-search-input" placeholder="Search">
          <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        @php
          $routeList  = Route::getRoutes();
          $Route      = [];
        @endphp
        @foreach ($routeList as $value)
              @permission(strtolower($value->getName()))
                @php 
                  $model = substr($value->getName(), 0, strpos($value->getName(), "."));
                  $Permission = \Ultraware\Roles\Models\Permission::where('slug',strtolower($value->getName()))->first(); 
                @endphp

                @if($Permission->sidebar == "ok")
                <li class="Management {{(str_replace('.index','',Route::current()->getName()) == $model)? 'active':''}}">
                  <a href="{{ url(route($value->getName())) }}"><i class="{{$Permission->icon}}"></i>
                    <span>{{$Permission->title}}</span>
                  </a>
                </li>

                
                
                @endif
               @endpermission
        @endforeach


        <?php /*
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Task</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{Route('unVerifiedCustomer')}}"><i class="fa fa-circle-o"></i> un-Verified</a></li>
            <li><a href="{{Route('unPublishProperty')}}"><i class="fa fa-circle-o"></i> un-Publish Property</a></li>
          </ul>
        </li>
        */?>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>


  