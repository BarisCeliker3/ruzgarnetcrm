
@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
 <script src="https://cdn.tailwindcss.com"></script>
<script type="text/javascript">
window.onload = function() {
  setInterval(function() {
    var date = new Date();
    if (date.getHours()==09 && date.getMinutes()==45 && date.getSeconds()==00) {
		var text_st = new Array(
		                        "RüzgarNet'in gücü, her bir üyenin gücüdür.", 
		                        "RüzgarNet seninle güzel", 
		                        "Sen varken, hep bir adım öndeyiz", 
								"Biz birlikte daha güçlüyüz", 
								"Şirketimizin enerjine ihtiyacı var", 
								"Bu yıl başarı yılı, destek ver", 
								"Sevgimizle dolusun", 
								"Işık saçıyorsun",
								"Gülüşünle günümüzü aydınlatıyorsun",
								"Sen varsan sorun yok",
								"Rüzgar gibi esmeye hazır mısın?",
								"Daha gidecek çok yolumuz var",
								"Bugün sahip oldukların için teşekkür et ve yarın sahip olacakların için savaşmaya başla!"
								);
		var l = text_st.length;
		var rnd_no = Math.floor(l*Math.random());
		
		swal.fire({
		  title: text_st[rnd_no],
		  text: "Günlük Görevlerini Kontrol Etmeyi Unutma!",
		  imageUrl: "https://www.ruzgarnet.com.tr/static/images/crmgorev/gorev-resim-5.png",
		  html:'',
		  confirmButtonText:
          '<i class="fa fa-thumbs-up"></i> Harika!😎'
		});
		
		}else if (date.getHours()==18 && date.getMinutes()==30 && date.getSeconds()==00) {
		swal.fire({
		  title: "Bugünün Görevlerini Kaydetmeyi Unutma!",
		  text: "Mutlu kal🥰",
		  imageUrl: "https://www.ruzgarnet.com.tr/static/images/crmgorev/gorev-resim-4.png",
		  html:''
		});
    }
    
  },1000);
};
</script>
@endpush

<style>
 .search-with-logo {
    background-image: url(/assets/images/ruzgarnetlogo.png);
    background-repeat: no-repeat;

    background-position: center;   /* sola yaslı ve ortalanmış */
    background-size: 100px;         /* daha küçük logo */
    background-color: rgba(255, 255, 255, 0.7); /* yarı saydam beyaz arkaplan */
    padding-left: 40px;                 /* yazı logoya çarpmasın */
    border-radius: 8px;                 /* köşeleri yuvarlat */
    border: 1px solid rgba(0, 0, 0, 0.1); /* hafif çerçeve */
    transition: background-color 0.3s ease;
}

.search-with-logo:focus {
    transform: scale(1.1); /* odaklanınca büyüme */
    background-image: none; /* arka planı tamamen gizle */
    background-size: 0; /* boyut sıfırlama */
}


</style>

<nav class="navbar navbar-expand-lg main-navbar">
   
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                <i class="fas fa-search"></i>
                    </a></li>
        </ul>
        <div class="search-element">
            <input class="form-control search-with-logo" name="q" id="inpSearch" type="search" aria-label=""
            data-width="250" autocomplete="off">
            <button style="justify-items: center;" class="btn" type="submit">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M14.757 20.171c-.791.523-1.738.829-2.757.829-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5c0 1.019-.306 1.966-.829 2.757l2.829 2.829-1.414 1.414-2.829-2.829zm-9.082-1.171c-3.438 0-5.675-2.629-5.675-5.5 0-2.702 1.951-4.945 4.521-5.408.212-3.951 3.473-7.092 7.479-7.092s7.267 3.141 7.479 7.092c2.57.463 4.521 2.706 4.521 5.408 0 2.855-2.218 5.5-5.675 5.5.3-.63.508-1.31.608-2.026 1.726-.214 3.067-1.691 3.067-3.474 0-2.969-2.688-3.766-4.432-3.72.323-3.983-2.115-6.78-5.568-6.78-3.359 0-5.734 2.562-5.567 6.78-1.954-.113-4.433.923-4.433 3.72 0 1.783 1.341 3.26 3.068 3.474.099.716.307 1.396.607 2.026m6.325-6c1.655 0 3 1.345 3 3s-1.345 3-3 3c-1.656 0-3-1.345-3-3s1.344-3 3-3"/></svg>
            </button>
            <div class="search-backdrop"></div>
            <div class="search-result">
                <div id="searchFields" class="placeholder">
                    <div class="results">
                        <div class="search-header">
                            @lang('tables.customer.title')
                        </div>
                        <div id="searchCustomer"></div>
                    </div>
                    <div class="empty">
                        <div class="search-message">
                            <div class="search-icon bg-primary text-white mr-2">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            @lang('titles.search.no_result')
                        </div>
                    </div>
                    <div class="placeholder">
                        <div class="search-message">
                            @lang('titles.search.placeholder')
                        </div>
                    </div>
                    <div class="loading">
                        <div class="search-message">
                            <div class="mr-2 text-primary search-loading-icon">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                            @lang('titles.search.loading')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div>

    </div>
    <ul class="navbar-nav navbar-right">
        {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Messages
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="/assets/images/ruzgar-logo-white.png" class="rounded-circle">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b>
                            <p>Hello, Bro!</p>
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="/assets/images/ruzgar-logo-white.png" class="rounded-circle">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Dedik Sugiharto</b>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="/assets/images/ruzgar-logo-white.png" class="rounded-circle">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Agung Ardiansyah</b>
                            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="/assets/images/ruzgar-logo-white.png" class="rounded-circle">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Ardian Rahardiansyah</b>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                            <div class="time">16 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="/assets/images/ruzgar-logo-white.png" class="rounded-circle">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Alfa Zulkarnain</b>
                            <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> --}}
        {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Template update is available now!
                            <div class="time text-primary">2 Min Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-success text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Low disk space. Let's clean it!
                            <div class="time">17 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Welcome to Stisla template!
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> --}}
      @if (request()->user()->role_id != 12)
    
      @endif
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="text-white">
                <div style="    display: flex !important
;" class="d-sm-none  d-flex align-items-center">
                    <img style="width: 60px; margin-right: 10px;" alt="image" src="/assets/images/staff.png" class="">
                    <span style=" 
                  font-weight: 800;
    border: 2px outset #715edb;
    border-radius: 5vh;
    padding: 9px;
    font-size: 13px;
    line-height: normal;
    font-family: initial;
    background: linear-gradient(135deg, #e7eaff, #d6acfb);
    color: #1e1b9b;
    box-shadow: 0 0 10px #87e6fe, 0 0 20px #4db8ff, 0 0 30px #4db8ff, 0 0 40px #4db8ff;
    transition: box-shadow 0.3s ease, transform 0.3s ease;

                    ">
                        {{ isset(request()->user()->staff) ? request()->user()->staff->full_name : request()->user()->username }}
                    </span>
                </div>
                
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="features-profile.html" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div> --}}
                <a class="dropdown-item has-icon text-danger" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> @lang('auth.logout')
                </a>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none"
                    data-ajax="false">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
