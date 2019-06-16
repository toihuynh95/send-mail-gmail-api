$(document).ready(function() {
    // Custom Scroll
    let height_scroll = Math.round($( window ).height() * 0.6);
    $(".custom-scrollable").css("max-height", height_scroll);
    // Auto Click The First List Group Contact Active
    $(window).on('load',function(){
        setTimeout(function () {
            $("#listGroupContactActive li:first-child a")[0].click();
        }, 100);
    });
    // Contact Group
    showGroupContact();
    storeGroupContact();
    updateGroupContact();
    showListGroupContactActive();
    showListGroupContactAll();

    // Contact
    showContact();
    storeContact();
    updateContact();
    importContact();
    exportContact();

    // Contact Group Detail

});

function activeClickLoadDataContactGroup(){
    $("#listGroupContactActive li").each(function() {
        $(this).removeClass('active');
        if ($(this).data("id") == document.getElementById("inputContactGroupIDCheck").value) {
            $(this).addClass("active");
        }
    });
}

function addClassActiveContactGroup(id){
    $('#listGroupContactActive li[data-id="'+id+'"]').addClass("active");
}

// Contact Group
let table_group_contact = $('#tableGroup');

function showGroupContact() {
    table_group_contact.DataTable({
        ajax: {
            method: "GET",
            url: API_CONTACT_GROUP_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'contact_group_id',
                name: 'contact_group_id'
            },
            {
                data: 'contact_group_name',
                name: 'contact_group_name'
            },
            {
                data: 'contact_group_status',
                name: 'contact_group_status',
                render: function ( data, type, columns, meta ) {
                    let contact_group_status = '<span class="btn btn-xs bg-maroon">Đã bị ẩn</span>';
                    if(data == 1) {
                        contact_group_status = '<span class="btn btn-xs bg-olive">Đang hiện</span>';
                    }
                    return contact_group_status;
                },
                width: "17%"
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-info" href="javascript:loadDataContactGroup(`+columns.contact_group_id+`)"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a> &nbsp;`;
                    action += `<a class="btn btn-xs btn-danger" href="javascript:deleteContactGroup(`+columns.contact_group_id+`)"><i class="fa fa-times"></i> Xóa</a>`;
                    return action;
                },
                className: "text-center",
                width: "25%"
            }
        ]
    });
}

function storeGroupContact() {
    $('#btnAddGroupContact').click(function () {
        let data = $("#addGroupContactForm").serialize();
        $.ajax({
            type: 'POST',
            url: API_CONTACT_GROUP_STORE,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_group_contact.DataTable().ajax.reload();
                $('#addGroupContactModal').modal('hide');
                $('#addGroupContactForm')[0].reset();
                showListGroupContactActive();
                showListGroupContactAll();
            }
        });
    });
}

function loadDataContactGroup(contact_group_id) {
    $('#updateGroupContactModal').modal('show');
    $.ajax({
        type: 'GET',
        url: API_CONTACT_GROUP_SHOW_BY_ID + contact_group_id,
        success: function(data, status, xhr) {
            $('#inputContactGroupID').val(contact_group_id);
            $('#inputContactGroupName').val(data.data.contact_group_name);
            $("#inputContactGroupStatus option[value="+data.data.contact_group_status+"]").prop('selected',true);
        }
    });
}

function updateGroupContact() {
    $('#btnUpdateGroupContact').click(function () {
        let contact_group_id = $('#inputContactGroupID').val();
        let data = $('#updateGroupContactForm').serialize();
        $.ajax({
            type: 'POST',
            url: API_CONTACT_GROUP_UPDATE + contact_group_id,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_group_contact.DataTable().ajax.reload();
                $('#updateGroupContactModal').modal('hide');
                showListGroupContactActive();
                showListGroupContactAll();
            }
        });
    });
}

function showListGroupContactActive() {
    $.ajax({
        type: 'GET',
        url: API_CONTACT_GROUP_SHOW_IS_ACTIVE,
        success: function(data, status, xhr) {
            let htmlList = '';
            for (const contact_group of data.data) {
                htmlList += `<li data-id="`+contact_group.contact_group_id+`"><a href="javascript:loadContactGroupDetail(`+contact_group.contact_group_id+`)"><i class="fa fa-circle-o text-red"></i> `+contact_group.contact_group_name+` <span class="label pull-right bg-green">`+contact_group.contact_group_amount+`</span></a></li>`;
            }
            if(data.data.length > 0){
                $('#listGroupContactActive').html(htmlList);
            }else {
                $('#listGroupContactActive').html(`<li data-id="0"><a href="javascript:loadContactGroupDetail(0)"><i class="fa fa-circle-o text-red"></i>Không có dữ liệu...</a></li>`);
            }
            setTimeout(function () {
                addClassActiveContactGroup(document.getElementById("inputContactGroupIDCheck").value);
            }, 100);
        }
    });
}

function showListGroupContactAll() {
    $.ajax({
        type: 'GET',
        url: API_CONTACT_GROUP_SHOW_ALL,
        success: function(data, status, xhr) {
            if(data.data.length > 0) {
                $('.selectListContactGroup')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="" selected="selected">Không chọn nhóm</option>')
                    .val('whatever');
                for (const contact_group of data.data) {
                    $('.selectListContactGroup').append($("<option></option>").attr("value", contact_group.contact_group_id).text(contact_group.contact_group_name));
                }
            }
        }
    });
}

function deleteContactGroup(contact_group_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa nhóm liên hệ này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'DELETE',
                url: API_CONTACT_GROUP_DESTROY + contact_group_id,
                success: function (data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_group_contact.DataTable().ajax.reload();
                    showListGroupContactActive();
                    showListGroupContactAll();
                }
            });
        }
    });
}

// Contact
let table_contact = $('#tableContact');

function showContact() {
    table_contact.DataTable({
        ajax: {
            method: "GET",
            url: API_CONTACT_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'contact_id',
                name: 'contact_id'
            },
            {
                data: 'contact_name',
                name: 'contact_name'
            },
            {
                data: 'contact_email',
                name: 'contact_email'
            },
            {
                data: 'contact_gender',
                name: 'contact_gender',
                render: function ( data, type, columns, meta ) {
                    let contact_gender = '';
                    if(data == 1){
                        contact_gender = '<span class="btn btn-xs bg-olive">Nam</span>';
                    }else if(data == 0){
                        contact_gender = '<span class="btn btn-xs bg-maroon">Nữ</span>';
                    }else {
                        contact_gender = '<span class="btn btn-xs bg-purple">Chưa xác định</span>';
                    }
                    return contact_gender;
                },
                width: "17%"
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-info" href="javascript:loadDataContact(`+columns.contact_id+`)"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a>`;
                    action += `&nbsp; <a class="btn btn-xs btn-danger" href="javascript:deleteContact(`+columns.contact_id+`)"><i class="fa fa-times"></i> Xóa</a>`;
                    return action;
                },
                className: "text-center",
                width: "25%"
            }
        ]
    });
}

function storeContact() {
    $('#btnAddContact').click(function () {
        $("#addContactForm").find('select option[value=""]').attr('disabled', true);
        let data = $("#addContactForm").serialize();
        $.ajax({
            type: 'POST',
            url: API_CONTACT_STORE,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_contact.DataTable().ajax.reload();
                $('#addContactModal').modal('hide');
                $('#addContactForm')[0].reset();
                showListGroupContactActive();
            }
        });
    });
}

function importContact() {
    $('#btnImportContact').click(function () {
        $("#importContactForm").find('select option[value=""]').attr('disabled', true);
        let data = new  FormData($("#importContactForm")[0]);
        $.ajax({
            processData: false,
            contentType: false,
            type: 'POST',
            url: API_CONTACT_IMPORT,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_contact.DataTable().ajax.reload();
                $('#addContactModal').modal('hide');
                $('#importContactForm')[0].reset();
                showListGroupContactActive();
            }
        });
    });
}

function exportContact() {
    $('#btnExportContact').click(function () {
        $.ajax({
            type: 'GET',
            url: API_CONTACT_EXPORT,
            success: function(data, status, xhr) {
                window.open(data.data);
            }
        });
    });
}

function loadDataContact(contact_id) {
    $('#updateContactModal').modal('show');
    $.ajax({
        type: 'GET',
        url: API_CONTACT_SHOW_BY_ID + contact_id,
        success: function(data, status, xhr) {
            $('#inputContactID').val(contact_id);
            $('#inputContactName').val(data.data.contact_name);
            $('#inputContactEmail').val(data.data.contact_email);
            $("#inputContactGender option[value="+data.data.contact_gender+"]").prop('selected',true);
        }
    });
}

function updateContact() {
    $('#btnUpdateContact').click(function () {
        let contact_id = $('#inputContactID').val();
        let data = $('#updateContactForm').serialize();
        $.ajax({
            type: 'POST',
            url: API_CONTACT_UPDATE + contact_id,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_contact.DataTable().ajax.reload();
                all_contact_datatable.DataTable().ajax.reload();
                table_contact_group_detail.DataTable().ajax.reload();
                $('#updateContactModal').modal('hide');
            }
        });
    });
}

let all_contact_datatable = $('#tableContactAllDatatable');
function showAllContactDatatable(contact_group_id) {
    all_contact_datatable.DataTable().destroy();
    all_contact_datatable.DataTable({
        ajax: {
            method: "GET",
            url: API_CONTACT_SHOW_EXCEPT_IN_GROUP + contact_group_id
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'contact_id',
                name: 'contact_id'
            },
            {
                data: 'contact_name',
                name: 'contact_name'
            },
            {
                data: 'contact_email',
                name: 'contact_email'
            },
            {
                data: 'contact_gender',
                name: 'contact_gender',
                render: function ( data, type, columns, meta ) {
                    let contact_gender = '';
                    if(data == 1){
                        contact_gender = '<span class="btn btn-xs bg-olive">Nam</span>';
                    }else if(data == 0){
                        contact_gender = '<span class="btn btn-xs bg-maroon">Nữ</span>';
                    }else {
                        contact_gender = '<span class="btn btn-xs bg-purple">Chưa xác định</span>';
                    }
                    return contact_gender;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-primary" href="javascript:addContactFromList(`+columns.contact_id+`)"><i class="fa fa-arrow-circle-down"></i> Thêm</a> &nbsp;`;
                    return action;
                },
                className: "text-center",
                width: "15%"
            }
        ]
    });
}

function deleteContact(contact_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa thông tin liên hệ này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
        .then((willACT) => {
            if (willACT) {
                $.ajax({
                    type: 'DELETE',
                    url: API_CONTACT_DESTROY + contact_id,
                    success: function (data, status, xhr) {
                        swal({
                            title: "Thao tác thành công!",
                            text: xhr.responseJSON.message,
                            icon: "success"
                        });
                        table_contact.DataTable().ajax.reload();
                        all_contact_datatable.DataTable().ajax.reload();
                    }
                });
            }
        });
}

// Contact Group Detail
let table_contact_group_detail = $('#tableContactGroupDetail');

function showContactGroupDetail($contact_group_id) {
    table_contact_group_detail.DataTable().destroy();
    table_contact_group_detail.DataTable({
        ajax: {
            method: "GET",
            url: API_CONTACT_GROUP_DETAIL_SHOW_BY_GROUP + $contact_group_id
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'contact_group_detail_id',
                name: 'contact_group_detail_id'
            },
            {
                data: 'contact_name',
                name: 'contact_name'
            },
            {
                data: 'contact_email',
                name: 'contact_email'
            },
            {
                data: 'contact_gender',
                name: 'contact_gender',
                render: function ( data, type, columns, meta ) {
                    let contact_gender = '';
                    if(data == 1){
                        contact_gender = '<span class="btn btn-xs bg-olive">Nam</span>';
                    }else if(data == 0){
                        contact_gender = '<span class="btn btn-xs bg-maroon">Nữ</span>';
                    }else {
                        contact_gender = '<span class="btn btn-xs bg-purple">Chưa xác định</span>';
                    }
                    return contact_gender;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-danger" href="javascript:deleteContactGroupDetail(`+columns.contact_group_detail_id+`,`+columns.contact_group_id+`)"><i class="fa fa-times"></i> Xóa</a>`;
                    return action;
                },
                className: "text-center",
                width: "15%"
            }
        ]
    });
}

function addContactFromList(contact_id) {
    let contact_group_id = $('#inputContactGroupIDCheck').val();
    let data = {contact_group_id: contact_group_id, contact_id: contact_id};
    $.ajax({
        type: 'POST',
        url: API_CONTACT_GROUP_DETAIL_STORE,
        data: data,
        success: function (data, status, xhr) {
            swal({
                title: "Thao tác thành công!",
                text: xhr.responseJSON.message,
                icon: "success"
            });
            all_contact_datatable.DataTable().ajax.reload();
            table_contact_group_detail.DataTable().ajax.reload();
            showListGroupContactActive();
        }
    });
}

function loadContactGroupDetail($contact_group_id) {
    showContactGroupDetail($contact_group_id);
    showAllContactDatatable($contact_group_id);
    $('#inputContactGroupIDCheck').val($contact_group_id);

    $('.nav-tabs a[href="#detail"]').tab('show');
    activeClickLoadDataContactGroup();
}

function deleteContactGroupDetail(contact_group_detail_id, contact_group_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa liên hệ này ra khỏi nhóm!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'DELETE',
                url: API_CONTACT_GROUP_DETAIL_DESTROY + contact_group_detail_id,
                success: function (data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_contact_group_detail.DataTable().ajax.reload();
                    all_contact_datatable.DataTable().ajax.reload();
                    showListGroupContactActive();
                    activeClickLoadDataContactGroup();
                }
            });
        }
    });
}
