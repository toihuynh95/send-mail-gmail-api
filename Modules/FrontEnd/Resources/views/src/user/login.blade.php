<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng nhập hệ thống</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/dist/css/AdminLTE.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/dist/css/skins/_all-skins.min.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <!-- Custom - Main - CSS -->
    <link rel="stylesheet" href="{{asset('public/css/main.css')}}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Đăng nhập hệ thống</b>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Đăng nhập để sử dụng hệ thống</p>
            <div class="form-group has-feedback">
                <input type="text" id="user_name" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" id="password" class="form-control" placeholder="Mật khẩu">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">
                </div>
                <div class="col-xs-6">
                    <button class="btn btn-primary btn-block btn-flat login" id="btnLogin">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery 3.3.1 -->
    <script src="{{asset('public/dist/js/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('public/vendor/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('public/vendor/adminlte/dist/js/adminlte.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('public/vendor/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('public/vendor/adminlte/bower_components/select2/dist/js/i18n/vi.js')}}"></script>
    {{--sweetalert--}}
    <script src="{{asset('public/dist/js/sweetalert.min.js')}}"></script>

    <!-- Custom - Router - JS -->
    <script src="{{asset('public/js/router.js')}}"></script>
    <!--user_Login js-->
    <script src="{{ asset('/public/js/user/login.js') }}"></script>
</body>
</html>
