$(document).ready(function() {
    showListUser();
    addUser();
    updateUser();
    generatePassword();
});

let table_user = $('#tableUser');

function showListUser() {
    table_user.DataTable({
        ajax: {
            method: "GET",
            url: API_USER_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'user_id',
                name: 'user_id'
            },
            {
                data: 'user_full_name',
                name: 'user_full_name'
            },
            {
                data: 'user_name',
                name: 'user_name'
            },
            {
                data: 'user_level',
                name: 'user_level',
                render: function ( data, type, columns, meta ) {
                    if(data == 2) return 'Quản trị viên cao cấp';
                    else if(data == 1) return 'Nhân viên';
                    else return 'Khách hàng';
                }
            },
            {
                data: 'user_status',
                name: 'user_status',
                render: function ( data, type, columns, meta ) {
                    return data == '1' ? '<span class="btn btn-xs bg-olive">Đang hoạt động</span>' : '<span class="btn btn-xs bg-maroon">Đã bị khóa</span>';
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = '';
                    if(isSuper() && getMyID() != columns.user_id){
                        action += `<a class="btn btn-xs btn-info" href="javascript:loadDataUser(`+columns.user_id+`)"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a>`;
                    }
                    if(getMyLevel() > columns.user_level){
                        if(columns.user_status == 0){
                            action += `&nbsp; <a href="javascript:unlockUser(`+columns.user_id+`)" class="btn btn-xs bg-orange"> <i class="fa fa-unlock"></i> Mở khóa</a>`;
                        }else {
                            action += `&nbsp; <a href="javascript:lockUser(`+columns.user_id+`)" class="btn btn-xs bg-orange"> <i class="fa fa-lock"></i> Khóa ngay</a>`;
                        }
                    }
                    if(isSuper() && getMyID() != columns.user_id && columns.user_level == 1){
                        action += `&nbsp; <a href="javascript:deleteUser(`+columns.user_id+`)" class="btn btn-xs btn-danger"> <i class="fa fa-times"></i> Xóa</a>`;
                    }
                    return action;
                },
                className: "text-center",
                width: "25%"
            }
        ]
    });
}

function addUser() {
    setTimeout(function () {
        if(!isSuper()){
            $('#inputUserLevel').find('option').remove().end() .append('<option value="0">Khách hàng</option>').prop('selected', true);
        }
    }, 100);
    $('#btnAddUser').click(function () {
        let data = new FormData($("#addUserForm")[0]);
        $.ajax({
            processData: false,
            contentType: false,
            type: 'POST',
            url: API_USER_STORE,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_user.DataTable().ajax.reload();
                $('#addUserModal').modal('hide');
                $('#addUserForm')[0].reset();
            }
        });
    });
}

function deleteUser(user_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa người dùng này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'DELETE',
                url: API_USER_DESTROY + user_id,
                success: function (data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_user.DataTable().ajax.reload();
                }
            });
        }
    });
}

function lockUser(user_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn khóa người dùng này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'POST',
                url: API_USER_LOCK,
                data: {'user_id' : user_id},
                success: function(data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_user.DataTable().ajax.reload();
                }
            });
        }
    });
}

function unlockUser(user_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn mở khóa người dùng này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'POST',
                url: API_USER_UNLOCK,
                data: {'user_id' : user_id},
                success: function(data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_user.DataTable().ajax.reload();
                }
            });
        }
    });
}

function loadDataUser(user_id) {
    $('#updateUserModal').modal('show');
    $.ajax({
        type: 'GET',
        url: API_USER_SHOW_BY_ID + user_id,
        success: function(data, status, xhr) {
            $('#user_id').val(user_id);
            $('#user_name').val(data.data.user_name);
        }
    });
}

function updateUser() {
    $('#btnUpdateUser').click(function () {
        let user_id = $('#user_id').val();
        let data = $('#updateUserForm').serialize();
        $.ajax({
            type: 'POST',
            url: API_USER_UPDATE + user_id,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_user.DataTable().ajax.reload();
                $('#updateUserModal').modal('hide');
            }
        });
    });
}

function generatePassword() {
    $("#inputGeneratePassword").change(function() {
        if(this.checked) {
            $.ajax({
                type: 'GET',
                url: API_USER_GENERATE_PASSWORD,
                success: function(data, status, xhr) {
                    $('#inputPassword').val(data.data.password);
                }
            });
        }else {
            $('#inputPassword').val('');
        }
    });
}
