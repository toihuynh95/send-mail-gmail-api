$(document).ready(function() {
    ajaxSetup();
    login();
    reset();
    checkTokenReset();
    changeNewPassword();
});

function ajaxSetup() {
    $.ajaxSetup({
        error: function (xhr) {
            if (xhr.status == 401 || xhr.status == 422 || xhr.status == 403 || xhr.status == 400) {
                swal({
                    title: "Đã có lỗi xảy ra!",
                    text: xhr.responseJSON.message,
                    icon: "error"
                });
            }
        }

    });
}

function login() {
    $('#btnLogin').click(function () {
        $.ajax({
            type: 'POST',
            url: API_USER_LOGIN,
            data : {
                'user_name' : $('#user_name').val(),
                'password' : $('#password').val()
            },
            success: function(data) {
                localStorage.setItem("token", data.data.access_token);
                $.ajax({
                    type: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + data.data.access_token
                    },
                    url: API_USER_ME,
                    success: function(data) {
                        if(data.data.user_level > 0){
                            window.location.href = "/user";
                        }else {
                            window.location.href = "/dashboard";
                        }
                    }
                });
            }
        });
    });
}

function reset() {
    $('#btnResetPassword').click(function () {
        $.ajax({
            type: 'POST',
            url: API_USER_FORGOT,
            data : $('#resetPasswordForm').serialize(),
            success: function(data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                $('#resetPasswordModal').modal('hide');
            }
        });
    });
}

function checkTokenReset() {
    let token = 'token';
    let url = window.location.href;
    if(url.indexOf('?' + token + '=') != -1){
        $.urlParam = function(name){
            let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            return results[1] || 0;
        };
        let access_token = $.urlParam(token);
        $.ajax({
            type: 'GET',
            url: API_USER_CHECK_TOKEN_RESET + access_token,
            success: function(data, status, xhr) {
                $('#createNewPasswordModal').modal('show');
            },
            error: function (xhr) {
                if (xhr.status == 422 || xhr.status == 400) {
                    swal({
                        title: "Đã có lỗi xảy ra!",
                        text: xhr.responseJSON.message,
                        icon: "error"
                    });
                    setTimeout(function () {
                        window.location.href = '/user/login';
                    }, 2000);
                }
            }
        });
    }
}

function changeNewPassword() {
    $('#btnCreateNewPassword').click(function () {
        let token = 'token';
        let url = window.location.href;
        if (url.indexOf('?' + token + '=') != -1) {
            $.urlParam = function (name) {
                let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
                return results[1] || 0;
            };
            let access_token = $.urlParam(token);
            $.ajax({
                type: 'POST',
                url: API_USER_CREATE_NEW_PASSWORD + access_token,
                data: $('#createNewPasswordForm').serialize(),
                success: function (data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    $('#createNewPasswordForm')[0].reset();
                    $('#createNewPasswordModal').modal('hide');
                    setTimeout(function () {
                        window.location.href = '/user/login';
                    }, 2000);
                }
            });
        }
    });
}

