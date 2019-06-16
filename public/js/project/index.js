$(document).ready(function() {
    showProject();
    showListProjectTypeAll();
    showListMailingServiceAll();
    storeProject();
    showListCustomerAll();
    updateProject();
});

// Project
let table_project = $('#tableProject');
function showProject() {
    table_project.DataTable({
        ajax: {
            method: "GET",
            url: API_PROJECT_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'project_id',
                name: 'project_id'
            },
            {
                data: 'project_name',
                name: 'project_name'
            },
            {
                data: 'customer_email',
                name: 'customer_email'
            },
            {
                data: 'contract_code',
                name: 'contract_code'
            },
            {
                data: 'project_type_name',
                name: 'project_type_name'
            },
            {
                data: 'mailing_service_name',
                name: 'mailing_service_name'
            },
            {
                data: 'project_created_at',
                name: 'project_created_at'
            },
            {
                data: 'project_status',
                name: 'project_status',
                render: function ( data, type, columns, meta ) {
                    let status = '<span class="btn btn-xs bg-maroon">Tạm khóa</span>';
                    if(columns.project_status == 1){
                        status = '<span class="btn btn-xs bg-olive">Hoạt động</span>';
                    }
                    return status;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-info" href="javascript:loadDataProject(`+columns.project_id+`)"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a>`;
                    if(columns.project_status == 0){
                        action += `&nbsp; <a href="javascript:updateProjectStatus(`+columns.project_id+`,1)" class="btn btn-xs bg-orange"> <i class="fa fa-unlock"></i> Mở khóa</a>`;
                    }else {
                        action += `&nbsp; <a href="javascript:updateProjectStatus(`+columns.project_id+`,0)" class="btn btn-xs bg-orange"> <i class="fa fa-lock"></i> Tạm khóa</a>`;
                    }
                    action += `&nbsp;<a class="btn btn-xs btn-danger" href="javascript:deleteProject(`+columns.project_id+`)"><i class="fa fa-times"></i> Xóa</a>`;
                    return action;
                },
                className: "text-center",
                width: "25%"
            }
        ]
    });
}

function showListProjectTypeAll() {
    $.ajax({
        type: 'GET',
        url: API_PROJECT_TYPE_SHOW_ALL,
        success: function(data, status, xhr) {
            if(data.data.length > 0) {
                $('.selectListProjectType').find('option').remove();
                for (const project_type of data.data) {
                    $('.selectListProjectType').append($("<option></option>").attr("value", project_type.project_type_id).text(project_type.project_type_name));
                }
            }
        }
    });
}

function showListMailingServiceAll() {
    $.ajax({
        type: 'GET',
        url: API_MAILING_SERVICE_SHOW_ALL,
        success: function(data, status, xhr) {
            if(data.data.length > 0) {
                $('.selectListMailingService').find('option').remove();
                for (const mailing_service of data.data) {
                    $('.selectListMailingService').append($("<option></option>").attr("value", mailing_service.mailing_service_id).text(mailing_service.mailing_service_name));
                }
            }
        }
    });
}

function showListCustomerAll() {
    $.ajax({
        type: 'GET',
        url: API_CUSTOMER_SHOW_ALL,
        success: function(data, status, xhr) {
            if(data.data.length > 0) {
                $('.selectListCustomer').find('option').remove();
                for (const customer of data.data) {
                    if(customer.customer_status == 1){
                        $('.selectListCustomer').append($("<option></option>").attr("value", customer.customer_id).text(customer.customer_name));
                    }else {
                        $('.selectListCustomer').append($("<option></option>").attr("value", customer.customer_id).text(customer.customer_name).attr('disabled', 'disabled'));
                    }
                }
            }
        }
    });
}

function storeProject() {
    $('#btnAddProject').click(function () {
        let data = $("#addProjectForm").serialize();
        $.ajax({
            type: 'POST',
            url: API_PROJECT_STORE,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_project.DataTable().ajax.reload();
                $('#addProjectModal').modal('hide');
                $('#addProjectForm')[0].reset();
            }
        });
    });
}

function loadDataProject(project_id) {
    $('#updateProjectModal').modal('show');
    $.ajax({
        type: 'GET',
        url: API_PROJECT_SHOW_BY_ID + project_id,
        success: function(data, status, xhr) {
            $('#inputProjectID').val(project_id);
            $('#inputProjectName').val(data.data.project_name);
            $('#inputContractCode').val(data.data.contract_code);
            $("#inputProjectTypeID").val(data.data.project_type_id).trigger('change');
            $("#inputProjectMailingServiceID").val(data.data.mailing_service_id).trigger('change');
            $("#inputCustomer option[value="+data.data.customer_id+"]").prop('selected',true);
        }
    });
}

function updateProject() {
    $('#btnUpdateProject').click(function () {
        let project_id = $('#inputProjectID').val();
        let data = $('#updateProjectForm').serialize();
        $.ajax({
            type: 'POST',
            url: API_PROJECT_UPDATE + project_id,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_project.DataTable().ajax.reload();
                $('#updateProjectModal').modal('hide');
            }
        });
    });
}

function deleteProject(project_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa dự án này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'DELETE',
                url: API_PROJECT_DESTROY + project_id,
                success: function (data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_project.DataTable().ajax.reload();
                }
            });
        }
    });
}

function updateProjectStatus(project_id, project_status) {
    $.ajax({
        type: 'POST',
        url: API_PROJECT_UPDATE + project_id,
        data: {'project_status': project_status},
        success: function (data, status, xhr) {
            swal({
                title: "Thao tác thành công!",
                text: 'Đã cập nhật trạng thái cho dự án thành công!',
                icon: "success"
            });
            table_project.DataTable().ajax.reload();
        }
    });
}
