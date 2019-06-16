$(document).ready(function() {
    if(!isAdmin()){
        showPersonalInfo();
        updatePersonalInfo();
    }else {
        $("#tabProfileInfo").hide();
    }
    uploadAvatar();
    getProfile();
    updateProfile();
    resetPassword();
});

function uploadAvatar() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#avatar-profile').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    $("#profile-image").on('change', function(){
        readURL(this);
        updateAvatar();
    });
}

function updateAvatar() {
    let data = new FormData($("#updateAvatar")[0]);

    $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        url: API_USER_UPDATE_AVATAR,
        data: data,
        success: function (data, status, xhr) {
            swal({
                title: "Thao tác thành công!",
                text: xhr.responseJSON.message,
                icon: "success"
            });

            setTimeout(() => {
                window.location.href = "/user/profile";
            }, 3000);
        }
    });
}


function getProfile() {
    $.ajax({
        type: 'GET',
        url: API_USER_ME,
        success: function(data) {
            $("#inputProfileName").val(data.data.user_full_name);
            $("#inputProfileEmail").val(data.data.user_name);
        }
    });
}

function updateProfile() {
    $('#btnUpdateProfile').click(function () {
        let data = $("#updateProfile").serialize();
        $.ajax({
            type: 'POST',
            url: API_USER_UPDATE_PROFILE,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });

                setTimeout(() => {
                    window.location.href = "/user/profile";
                }, 3000);
            }
        });
    });
}

function resetPassword() {
    $('#btnResetPassword').click(function () {
        let data = $("#resetPassword").serialize();
        $.ajax({
            type: 'POST',
            url: API_USER_RESET_PASSWORD,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });

                setTimeout(() => {
                    window.location.href = "/user/login";
                }, 3000);
            }
        });
    });
}

function showPersonalInfo() {
    $.ajax({
        type: 'GET',
        url: API_CUSTOMER_SHOW_PERSONAL_INFO,
        success: function (data, status, xhr) {
            $('#inputCustomerName').val(data.data.customer_name);
            $('#inputCustomerEmail').val(data.data.customer_email);
            $('#inputCustomerPhone').val(data.data.customer_phone);
            $('#inputCustomerAddress').val(data.data.customer_address);
            $("#inputCustomerGender option[value="+data.data.customer_gender+"]").prop('selected',true);
        }
    });
}

function updatePersonalInfo() {
    $('#btnUpdatePersonalInfo').click(function () {
        let data = $("#updatePersonalInfo").serialize();
        $.ajax({
            type: 'POST',
            url: API_CUSTOMER_UPDATE_PERSONAL_INFO,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
            }
        });
    });
}
