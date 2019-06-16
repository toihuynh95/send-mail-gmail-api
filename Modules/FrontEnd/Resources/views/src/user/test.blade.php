<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng nhập hệ thống</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/plugins/login-v1/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/plugins/login-v1/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/plugins/login-v1/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/plugins/login-v1/css/main.css')}}">
    <!--===============================================================================================-->
    <style>
        .login100-form-title {
            font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
            font-weight: bold;
        }
        .swal-footer {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{asset('public/plugins/login-v1/images/img-01.png')}}" alt="IMG">
            </div>
            <div class="login100-form validate-form">
                <span class="login100-form-title">
                    ĐĂNG NHẬP HỆ THỐNG
                </span>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" id="user_name" placeholder="Email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" id="password" placeholder="Mật khẩu">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" id="btnLogin">
                        Đăng nhập
                    </button>
                </div>

                <div class="text-center p-t-12">
                    <a class="txt2" href="#" data-toggle="modal" data-target="#resetPasswordModal">
                        Quên mật khẩu?
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="#">
                        Liên hệ hỗ trợ
                        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i> (+84) 904 420 410
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="resetPasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Yêu cầu đặt lại mật khẩu mới</h4>
            </div>
            <form id="resetPasswordForm">
                <div class="modal-body">
                    <mark>Đừng quá lo lắng. Chỉ cần nhập địa chỉ email của bạn dưới đây và chúng tôi sẽ gửi cho bạn một email hướng dẫn để phục hồi mật khẩu.</mark><br/><br/>
                    <div class="form-group">
                        <label for="email">Tài khoản</label>
                        <input type="text" name="user_name" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnResetPassword" class="btn btn-primary pull-right"><i class="fa fa-paper-plane"></i> Gửi yêu cầu</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="createNewPasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Yêu cầu đặt lại mật khẩu mới</h4>
            </div>
            <form id="createNewPasswordForm">
                <div class="modal-body">
                    <div class="form-group required">
                        <label for="email">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới">
                    </div>

                    <div class="form-group required">
                        <label for="email">Nhập lại mật khẩu mới</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnCreateNewPassword" class="btn btn-primary pull-right"><i class="fa fa-paper-plane"></i> Thay đổi mật khẩu</button>
                </div>
            </form>
        </div>

    </div>
</div>


<!-- jQuery 3.3.1 -->
<script src="{{asset('public/dist/js/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/plugins/login-v1/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('public/vendor/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('public/vendor/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('public/plugins/login-v1/vendor/tilt/tilt.jquery.min.js')}}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="{{asset('public/plugins/login-v1/js/main.js')}}"></script>
{{--sweetalert--}}
<script src="{{asset('public/dist/js/sweetalert.min.js')}}"></script>

<!-- Custom - Router - JS -->
<script src="{{asset('public/js/router.js')}}"></script>
<!--user_Login js-->
<script src="{{ asset('/public/js/user/login.js') }}"></script>

</body>
</html>
