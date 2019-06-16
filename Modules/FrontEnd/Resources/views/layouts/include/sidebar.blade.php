<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('public/vendor/adminlte/dist/img/my-account-icon.jpg')}}" class="img-circle avatar" alt="User Image">
            </div>
            <div class="pull-left info">
                <p class="profileName"></p>
                <a href="#" class="userLevel"><i class="fa fa-circle text-success"></i></a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Tìm kiếm...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <ul class="sidebar-menu tree" data-widget="tree">
            <li id="sidebar-menu-dashboard" style="display: none;"><a href="{{url('dashboard')}}"><i class="fa fa-user"></i><span>Tổng quan hệ thống</span></a></li>
            <li id="sidebar-menu-user" style="display: none;"><a href="{{url('user')}}"><i class="fa fa-user"></i><span>Tài khoản người dùng</span></a></li>
            <li id="sidebar-menu-customer" style="display: none;"><a href="{{url('customer')}}"><i class="fa fa-ioxhost"></i><span>Thông tin khách hàng</span></a></li>
            <li id="sidebar-menu-contact" style="display: none;"><a href="{{url('contact')}}"><i class="fa fa-address-card"></i><span>Quản lý thông tin liên hệ</span></a></li>
            <li id="sidebar-menu-project-manager" style="display: none;"><a href="{{url('project')}}"><i class="fa fa-product-hunt"></i><span>Quản lý dự án</span></a></li>
            <li id="sidebar-menu-project-customer" style="display: none;"><a href="{{url('project/me')}}"><i class="fa fa-product-hunt"></i><span>Thông tin dự án</span></a></li>
            <li id="sidebar-menu-setting" style="display: none;"><a href="{{url('setting')}}"><i class="fa fa-cogs"></i><span>Cài đặt chung</span></a></li>
            <li id="sidebar-menu-campaign" style="display: none;"><a href="{{url('campaign')}}"><i class="fa fa-file-archive-o"></i><span>Quản lý chiến dịch</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
