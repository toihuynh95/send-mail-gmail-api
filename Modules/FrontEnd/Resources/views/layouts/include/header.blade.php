<header class="main-header">
    <!-- Logo -->
    <a href="{{url("")}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>E</b>MK</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>   </b> Email Marketing</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('public/vendor/adminlte/dist/img/my-account-icon.jpg')}}" class="user-image avatar"
                             alt="User Image">
                        <span class="hidden-xs profileName"></span>  <i class="fa fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{asset('public/vendor/adminlte/dist/img/my-account-icon.jpg')}}" class="img-circle avatar"
                                 alt="User Image">
                            <p class="profileName"></p>

                            <small><p class="userLevel"></p></small>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{asset('user/profile')}}" id="btnProfile" class="btn btn-default btn-flat">Thông tin cá nhân</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" id="btnLogout" class="btn btn-default btn-flat">Đăng xuất</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
