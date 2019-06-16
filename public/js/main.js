$(document).ready(function() {
    //Initialize Select2 Elements
    $('.select2').select2({
        language: "vi",
        width: "100%"
    });
    // Init Summer Note
    $( () => {
        $('.summernote').summernote({
            height: 200,
            placeholder: 'Vui lòng nhập nội dung...',
            codemirror: {
                theme: 'monokai'
            },
            focus: true,
            lang: 'vi-VN'
        });
    });
    // DateTime Picker
    $('.datetimepicker').datetimepicker({
        // locale: 'vi',
        minDate: Date.now(),
        format: 'YYYY-MM-DD HH:mm:ss',
        ignoreReadonly: true
    });
    // Function
    activeMenuBar();
    ajaxSetup();
    getInfo();
    logout();
    // Check is Admin
    isAdmin();
    //
    permissonMenuBar();
});
// Loadding
$(document).ajaxStart(function() {
    $("#loader").css('display', 'block');
});

$(document).ajaxStop(function() {
    $("#loader").css('display', 'none');
});


// Support

function permissonMenuBar() {
    setTimeout(function () {
        if(!isAdmin()){
            $("#sidebar-menu-dashboard").css({"display": "block"});
            $("#sidebar-menu-project-customer").css({"display": "block"});
            $("#sidebar-menu-contact").css({"display": "block"});
            $("#sidebar-menu-campaign").css({"display": "block"});
        }else {
            $("#sidebar-menu-user").css({"display": "block"});
            $("#sidebar-menu-customer").css({"display": "block"});
            $("#sidebar-menu-project-manager").css({"display": "block"});
            $("#sidebar-menu-setting").css({"display": "block"});
        }
    }, 100);
}

function isAdmin() {
    var IS_ADMIN = false;
    var user_level = localStorage.getItem("user_level");
    if(user_level > 0){
        IS_ADMIN = true;
    }
    return IS_ADMIN;
}

function isSuper() {
    var user_level = localStorage.getItem("user_level");
    if(user_level == 2){
        return true;
    }
    return false;
}

function getMyLevel() {
    return localStorage.getItem("user_level");
}

function getMyID() {
    return localStorage.getItem("user_id");
}

function getJwtToken() {
    var token = localStorage.getItem("token");
    if (token === null) {
        window.location.href = "/user/login";
    }
    return token;
}

// Running

function getInfo() {
    $.ajax({
        type: 'GET',
        url: API_USER_ME,
        success: function(data) {
            $(".profileName").append(data.data.user_full_name);
            // Set User Level -> Permission
            localStorage.setItem("user_level", data.data.user_level);
            // Set ID User
            localStorage.setItem("user_id", data.data.user_id);
            let user_level = "";
            if(data.data.user_level == 2){
                user_level= "Quản trị viên cao cấp";
            }
            else if(data.data.user_level == 1){
                user_level= "Nhân viên";
            }
            else {
                user_level= "Khách hàng";
            }
            $(".userLevel").append(user_level);
            let user_avatar = data.data.user_avatar;
            if(user_avatar) {
                $(".avatar").attr("src", user_avatar);
            }
            $(".userName").append(data.data.user_name);
        }
    });
}

function ajaxSetup() {
    $.fn.dataTable.ext.errMode = 'none';
    $.extend($.fn.dataTable.defaults.oLanguage, {
        sEmptyTable: "Không có dữ liệu trong bảng",
        sSearch: "Tìm kiếm nhanh:",
        sLoadingRecords: "Đang tải dữ liệu...",
        sLengthMenu: "Số mục hiển thị _MENU_ mục / trang",
        sProcessing: "Đang xử lý...",
        sZeroRecords: "Không tìm thấy dòng nào phù hợp",
        sInfo: "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
        sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
        sInfoFiltered: "(được lọc từ _MAX_ mục)",
        sInfoPostFix: "",
        sUrl: "",
        oPaginate: {
            sFirst: "Đầu",
            sPrevious: "Trước",
            sNext: "Tiếp",
            sLast: "Cuối"
        }
    });
    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + getJwtToken()
        },
        error: function (xhr) {
            if (xhr.status == 401 || xhr.status == 403) {
                swal({
                    title: "Đã có lỗi xảy ra!",
                    text: xhr.responseJSON.message,
                    icon: "error",
                    timer: 2000
                });
                localStorage.clear();
                setTimeout(() => {
                    window.location.href = "/user/login";
                }, 3000)
            }
            if (xhr.status == 422 || xhr.status == 400) {
                swal({
                    title: "Đã có lỗi xảy ra!",
                    text: xhr.responseJSON.message,
                    icon: "error"
                });
            }
        }
    });
}

function logout() {
    $('#btnLogout').click(function () {
        swal({
            title: "Bạn có chắc chắn rằng?",
            text: "Muốn thoát khỏi hệ thống!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'GET',
                    url: API_USER_LOGOUT,
                    success: function(user_logout) {
                        localStorage.clear();
                        window.location.href = "/user/login";
                    }
                });
            }
        });
    });
}

function activeMenuBar() {
    localStorage.setItem('url',window.location.href);
    var url=localStorage.getItem('url');
    var string =url.split('/');
    $("ul.sidebar-menu li:first-child").addClass('active');
    $("ul.sidebar-menu li").each(function(){
        var urls=$(this).find('a').attr('href');
        var url_check=urls.split('/');
        if(url_check[3]==string[3])
        {
            $("ul.sidebar-menu li:first-child").removeClass('active');
            $(this).addClass('active');
        }
    });
    $("ul.sidebar-menu li ul li").each(function(){
        var urls=$(this).find('a').attr('href');
        var url_check=urls.split('/');
        if(url_check[3]==string[3])
        {
            $("ul.sidebar-menu li").removeClass('active');
            $(this).parent('ul').parent('li').addClass('active');
            $(this).addClass('active');
        }
    });
}
