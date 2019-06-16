$(document).ready(function() {
    // Template
    showTemplate();
    storeTemplate();
    updateTemplate();
    // Mailing Service
    showMailingService();
    storeMailingService();
    updateMailingService();
    // Project Type
    showProjectType();
    storeProjectType();
    updateProjectType();
});

// Project Type
let table_project_type = $('#tableProjectType');
function showProjectType() {
    table_project_type.DataTable({
        ajax: {
            method: "GET",
            url: API_PROJECT_TYPE_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'project_type_id',
                name: 'project_type_id'
            },
            {
                data: 'project_type_name',
                name: 'project_type_name'
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-info" href="javascript:loadDataProjectType(`+columns.project_type_id+`)"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a> &nbsp;`;
                    action += `<a class="btn btn-xs btn-danger" href="javascript:deleteProjectType(`+columns.project_type_id+`)"><i class="fa fa-times"></i> Xóa</a>`;
                    return action;
                },
                className: "text-center",
                width: "25%"
            }
        ]
    });
}

function storeProjectType() {
    $('#btnAddProjectType').click(function () {
        let data = $("#addProjectTypeForm").serialize();
        $.ajax({
            type: 'POST',
            url: API_PROJECT_TYPE_STORE,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_project_type.DataTable().ajax.reload();
                $('#addProjectTypeModal').modal('hide');
                $('#addProjectTypeForm')[0].reset();
            }
        });
    });
}

function loadDataProjectType(project_type_id) {
    $('#updateProjectTypeModal').modal('show');
    $.ajax({
        type: 'GET',
        url: API_PROJECT_TYPE_SHOW_BY_ID + project_type_id,
        success: function(data, status, xhr) {
            $('#inputProjectTypeID').val(project_type_id);
            $('#inputProjectTypeName').val(data.data.project_type_name);
        }
    });
}

function updateProjectType() {
    $('#btnUpdateProjectType').click(function () {
        let project_type_id = $('#inputProjectTypeID').val();
        let data = $('#updateProjectTypeForm').serialize();
        $.ajax({
            type: 'POST',
            url: API_PROJECT_TYPE_UPDATE + project_type_id,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_project_type.DataTable().ajax.reload();
                $('#updateProjectTypeModal').modal('hide');
            }
        });
    });
}

function deleteProjectType(project_type_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa loại dự án này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'DELETE',
                url: API_PROJECT_TYPE_DESTROY + project_type_id,
                success: function (data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_project_type.DataTable().ajax.reload();
                }
            });
        }
    });
}

// Mailing Service
let table_mailing_service = $('#tableMailingService');
function showMailingService() {
    table_mailing_service.DataTable({
        ajax: {
            method: "GET",
            url: API_MAILING_SERVICE_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'mailing_service_id',
                name: 'mailing_service_id'
            },
            {
                data: 'mailing_service_name',
                name: 'mailing_service_name'
            },
            {
                data: 'mailing_service_amount',
                name: 'mailing_service_amount'
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-info" href="javascript:loadDataMailingService(`+columns.mailing_service_id+`)"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a> &nbsp;`;
                    action += `<a class="btn btn-xs btn-danger" href="javascript:deleteMailingService(`+columns.mailing_service_id+`)"><i class="fa fa-times"></i> Xóa</a>`;
                    return action;
                },
                className: "text-center",
                width: "25%"
            }
        ]
    });
}

function storeMailingService() {
    $('#btnAddMailingService').click(function () {
        let data = $("#addMailingServiceForm").serialize();
        $.ajax({
            type: 'POST',
            url: API_MAILING_SERVICE_STORE,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_mailing_service.DataTable().ajax.reload();
                $('#addMailingServiceModal').modal('hide');
                $('#addMailingServiceForm')[0].reset();
            }
        });
    });
}

function loadDataMailingService(mailing_service_id) {
    $('#updateMailingServiceModal').modal('show');
    $.ajax({
        type: 'GET',
        url: API_MAILING_SERVICE_SHOW_BY_ID + mailing_service_id,
        success: function(data, status, xhr) {
            $('#inputMailingServiceID').val(mailing_service_id);
            $('#inputMailingServiceName').val(data.data.mailing_service_name);
            $('#inputMailingServiceAmount').val(data.data.mailing_service_amount);
        }
    });
}

function updateMailingService() {
    $('#btnUpdateMailingService').click(function () {
        let mailing_service_id = $('#inputMailingServiceID').val();
        let data = $('#updateMailingServiceForm').serialize();
        $.ajax({
            type: 'POST',
            url: API_MAILING_SERVICE_UPDATE + mailing_service_id,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_mailing_service.DataTable().ajax.reload();
                $('#updateMailingServiceModal').modal('hide');
            }
        });
    });
}

function deleteMailingService(mailing_service_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa gói dịch vụ này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
    .then((willACT) => {
        if (willACT) {
            $.ajax({
                type: 'DELETE',
                url: API_MAILING_SERVICE_DESTROY + mailing_service_id,
                success: function (data, status, xhr) {
                    swal({
                        title: "Thao tác thành công!",
                        text: xhr.responseJSON.message,
                        icon: "success"
                    });
                    table_mailing_service.DataTable().ajax.reload();
                }
            });
        }
    });
}

// Template
let table_template = $('#tableTemplate');
function showTemplate() {
    table_template.DataTable({
        ajax: {
            method: "GET",
            url: API_TEMPLATE_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'template_id',
                name: 'template_id'
            },
            {
                data: 'template_name',
                name: 'template_name'
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-info" href="javascript:loadDataTemplate(`+columns.template_id+`)"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a> &nbsp;`;
                    action += `<a class="btn btn-xs btn-danger" href="javascript:deleteTemplate(`+columns.template_id+`)"><i class="fa fa-times"></i> Xóa</a>`;
                    return action;
                },
                className: "text-center",
                width: "25%"
            }
        ]
    });
}

function storeTemplate() {
    $('#btnAddTemplate').click(function () {
        let data = $("#addTemplateForm").serialize();
        $.ajax({
            type: 'POST',
            url: API_TEMPLATE_STORE,
            data : data,
            success: function(data, status, xhr) {
                swal({
                    title: "Thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_template.DataTable().ajax.reload();
                $('#addTemplateModal').modal('hide');
                $('#addTemplateForm')[0].reset();
                $('#txtAddTemplateContent').summernote('reset');
            }
        });
    });
}

function loadDataTemplate(template_id) {
    $('#updateTemplateModal').modal('show');
    $('#txtUpdateTemplateContent').summernote('reset');
    $.ajax({
        type: 'GET',
        url: API_TEMPLATE_SHOW_BY_ID + template_id,
        success: function(data, status, xhr) {
            $('#inputTemplateID').val(template_id);
            $('#inputTemplateName').val(data.data.template_name);
            $('#txtUpdateTemplateContent').summernote('pasteHTML', data.data.template_content);
        }
    });
}

function updateTemplate() {
    $('#btnUpdateTemplate').click(function () {
        let template_id = $('#inputTemplateID').val();
        let data = $('#updateTemplateForm').serialize();
        $.ajax({
            type: 'POST',
            url: API_TEMPLATE_UPDATE + template_id,
            data: data,
            success: function (data, status, xhr) {
                swal({
                    title: "Thao tác thành công!",
                    text: xhr.responseJSON.message,
                    icon: "success"
                });
                table_template.DataTable().ajax.reload();
                $('#updateTemplateModal').modal('hide');
                $('#txtUpdateTemplateContent').summernote('reset');
            }
        });
    });
}

function deleteTemplate(template_id) {
    swal({
        title: "Bạn có chắc chắn rằng?",
        text: "Muốn xóa mẫu email này!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
        .then((willACT) => {
            if (willACT) {
                $.ajax({
                    type: 'DELETE',
                    url: API_TEMPLATE_DESTROY + template_id,
                    success: function (data, status, xhr) {
                        swal({
                            title: "Thao tác thành công!",
                            text: xhr.responseJSON.message,
                            icon: "success"
                        });
                        table_template.DataTable().ajax.reload();
                    }
                });
            }
        });
}
