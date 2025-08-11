
<style>
 
</style>
<div class="main-sidebar ">
    <style>
        #ascrail2000{
            left: 242px !important;
        }
        .nicescroll-cursors{
            width:10px !important;
        }
    </style>
    <aside id="sidebar-wrapper">
        @if (request()->user()->role_id != 12)
        <div class="sidebar-logo  sidebar-brand    py-2 rounded-lg shadow-md flex items-center justify-center">
            <a href="{{ route('admin.dashboard') }}" class="text-white  text-2xl font-semibold text-center tracking-wide hover:opacity-80 transition-all">
                <img style="width:100%;margin:auto;margin-top:15px;" alt="image" src="/assets/images/ruzgarcrm3.png" class="">

            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}" class="neon-text">RC</a>

        </div>
        @endif
        @if (request()->user()->role_id == 12)
         <div class="sidebar-brand">
             <span  class="badge badge-pill badge-primary"><a style="color:white;" href="{{ route('admin.kurulums') }}">Internet Kurulum</a></span>
        </div>
        @endif
        @if (request()->user()->role_id != 12)
        <ul class="sidebar-menu ">
            @foreach ($admin->sideNav() as $nav)
                @if (isset($nav['can']) && $nav['can'] == true)
                    @if (isset($nav['header']) && $nav['header'] !== null)
                    <li class="menu-header text-black text-xxl font-semibold flex items-center justify-center gap-2">
                        <span style="color:#00f0ff;">&#x25C0;</span> <!-- Sol ok: ◀ -->
                        {{ $nav['header'] }}
                        <span style="color:#ff0e9f;">&#x25B6;</span> <!-- Sağ ok: ▶ -->
                    </li>
                    @else
                        @isset($nav['submenu'])
                        <li class="nav-item dropdown @if ($nav['active']==true) bg-blue-100 text-red-600 font-semibold @endif">

                                <a href="{{ isset($nav['route']) ? route($nav['route']) : '#' }}"
                                    class="nav-link has-dropdown">
                                    <img style="width:30%;margin:auto;margin-top:15px;" alt="image" src="/assets/images/ruzgarcrmtik.png" class="">
                                    <span>{{ $nav['title'] }}</span>
                                </a>

                                <ul class="dropdown-menu">
                                    @foreach ($nav['submenu'] as $subnav)
                                        @if (isset($subnav['can']) && $subnav['can'] == true)
                                            <li @if ($subnav['active'] == true) class="active" @endif>
                                                <a class="nav-link" href="{{ route($subnav['route']) }}">
                                                    {{ $subnav['title'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li @if ($nav['active'] == true) class="active" @endif>
                                <a style="margin-top:10px;border:solid 2px rgb(177, 177, 255);border-radius:5vh;
       box-shadow: 0 0 16px #c6b7ff, 0 0 15px #ffffff;
       transition: box-shadow 0.3s ease;
                                " href="{{ route($nav['route']) }}" class="nav-link">
                                    <img style="width:30px;margin:auto;" alt="image" src="/assets/images/ruzgarcrmtik.png" class="">
                                    <span>{{ $nav['title'] }}</span>
                                </a>
                            </li>
                        @endisset
                    @endif
                @endif
            @endforeach
        </ul>
                <ul  class="sidebar-menu">
                        <li class="menu-header"></li>
                            <li  class="nav-item active">
                                <a href="{{route('admin.task')}}"
                                    class="nav-link">
                                    <i class="fa fa-address-card"></i>
                                    <span style="text-transform:capitalize;">Gorev Takip</span>
                                </a>
                            </li>
                      </ul>
                      
        @endif              
    </aside>
</div>
