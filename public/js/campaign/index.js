$(document).ready(function() {
    // Xử lý lấy thông tin sau khi xác thực
    let id = 'id';
    let email = 'email';
    let url = window.location.href;
    if(url.indexOf('?' + id + '=') != -1 && url.indexOf('&' + email + '=') != -1){
        $.urlParam = function(name){
            let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            return results[1] || 0;
        };
        localStorage.setItem('campaign_email_id',$.urlParam(id));
        localStorage.setItem('campaign_email_name',$.urlParam(email));
    }
    let campaign_email_id = localStorage.getItem('campaign_email_id');
    let campaign_email_name = localStorage.getItem('campaign_email_name');

    if(!campaign_email_id || !campaign_email_name){
        $('#btnAddCampaignModal').prop('disabled', true);
        $('#authGoogleModal').modal('show');
    }else {
        $('#inputCampaignEmailID').val(campaign_email_id);
        $('#inputCampaignEmailName').val(campaign_email_name);
        $('#btnAddCampaignModal').prop('disabled', false);
    }
    // Xử lý số lượng tín dụng

    $('#selectProJect').change(function() {
        if ($(this).val() === '2') {
            // Do something for option "b"
        }
    });

    let group = $('#selectContactGroup');
    let project = $('#selectProJect');
    $('.checkChange').change( () => {
        if($('#selectContactGroup').val() && $('#selectProJect').val()){
            let group_value = group.val();
            let project_value = project.val();
            $.ajax({
                type: 'GET',
                url: API_PROJECT_CHECK_CONTACT_GROUP + project_value + '/' + group_value,
                success: function(data, status, xhr) {

                }
            });
        }
    });

    // Call Function
    showCampaign();
    storeCampaign();
    showListProject();
    showListGroupContactAll();
    showListTemplateAll();
    insertTemplateToContent();
});

let table_campaign = $('#tableCampaign');
function showCampaign() {
    table_campaign.DataTable({
        ajax: {
            method: "GET",
            url: API_CAMPAIGN_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'campaign_id',
                name: 'campaign_id'
            },
            {
                data: 'project_name',
                name: 'project_name'
            },
            {
                data: 'campaign_name',
                name: 'campaign_name'
            },
            {
                data: 'campaign_email_name',
                name: 'campaign_email_name'
            },
            {
                data: 'campaign_title',
                name: 'campaign_title'
            },
            {
                data: 'campaign_schedule',
                name: 'campaign_schedule'
            },
            {
                data: 'campaign_created_at',
                name: 'campaign_created_at'
            },
            {
                data: 'campaign_status',
                name: 'campaign_status',
                render: function ( data, type, columns, meta ) {
                    let status = '';
                    if(columns.campaign_status == 0){
                        status = '<span class="btn btn-xs btn-dropbox">Chờ xử lý</span>';
                    }else {
                        status = '<span class="btn btn-xs bg-olive">Hoàn thành</span>';
                    }
                    return status;
                },
                className: "text-center"
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function ( data, type, columns, meta ) {
                    let action = `<a class="btn btn-xs btn-primary" href="javascript:loadDataCampaign(`+columns.campaign_id+`)"><i class="fa fa-eye"></i> Chi tiết</a>`;
                    action += `&nbsp;<a class="btn btn-xs btn-success" href="javascript:loadDataCampaignLog(`+columns.campaign_id+`)"><i class="fa fa-external-link-square"></i> Xem thêm</a>`;
                    return action;
                },
                className: "text-center"
            }
        ]
    });
}

function storeCampaign() {
    $('#btnAddCampaign').click(function () {
        swal({
            title: "Bạn có chắc chắn rằng?",
            text: "Muốn thêm chiến dịch! Nếu xác nhận bạn sẽ không thể chỉnh sửa?",
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
        .then((willACT) => {
            if (willACT) {
                let data = $("#addCampaignForm").serialize();
                $.ajax({
                    type: 'POST',
                    url: API_CAMPAIGN_STORE,
                    data : data,
                    success: function(data, status, xhr) {
                        swal({
                            title: "Thành công!",
                            text: xhr.responseJSON.message,
                            icon: "success"
                        });
                        table_campaign.DataTable().ajax.reload();
                        $('#addCampaignModal').modal('hide');
                        $('#addCampaignForm')[0].reset();
                        $('#txtAddCampaignContent').summernote('reset');
                    }
                });
            }
        });
    });
}

function showListProject() {
    $.ajax({
        type: 'GET',
        url: API_PROJECT_SHOW_LIST,
        success: function(data, status, xhr) {
            if(data.data.length > 0) {
                $('.selectListProject').find('option').remove().end().append('<option value="" selected="selected">Chưa chọn dự án</option>').val('whatever');
                for (const project of data.data) {
                    if(project.project_status == 1){
                        $('.selectListProject').append($("<option></option>").attr("value", project.project_id).text(project.project_name));
                    }else {
                        $('.selectListProject').append($("<option></option>").attr("value", project.project_id).text(project.project_name).attr('disabled', 'disabled'));
                    }
                }
            }
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
                    .append('<option value="" selected="selected">Chưa chọn nhóm</option>')
                    .val('whatever');
                for (const contact_group of data.data) {
                    if(contact_group.contact_group_amount > 0){
                        $('.selectListContactGroup').append($("<option></option>").attr("value", contact_group.contact_group_id).text(contact_group.contact_group_name));
                    }else {
                        $('.selectListContactGroup').append($("<option></option>").attr("value", contact_group.contact_group_id).text(contact_group.contact_group_name).attr('disabled', 'disabled'));
                    }
                }
            }
        }
    });
}

let table_campaign_log = $('#tableCampaignLog');
function showCampaignLog(campaign_id) {
    $('#infoCampaignLogModal').modal('show');
    countSend(campaign_id);
    table_campaign_log.DataTable({
        ajax: {
            method: "GET",
            url: API_CAMPAIGN_LOG_SHOW + campaign_id
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'campaign_log_id',
                name: 'campaign_log_id'
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
                    let customer_gender = '';
                    if(data == 1){
                        customer_gender = '<span class="btn btn-xs bg-olive">Nam</span>';
                    }else if(data == 0){
                        customer_gender = '<span class="btn btn-xs bg-maroon">Nữ</span>';
                    }else {
                        customer_gender = '<span class="btn btn-xs bg-purple">Chưa xác định</span>';
                    }
                    return customer_gender;
                }
            },
            {
                data: 'campaign_log_status',
                name: 'campaign_log_status',
                render: function ( data, type, columns, meta ) {
                    let status = '';
                    if(columns.campaign_log_status == 1){
                        status = '<span class="btn btn-xs btn-success">Đã gửi</span>';
                    }else if(columns.campaign_log_status == 0){
                        status = '<span class="btn btn-xs btn-primary">Chưa gửi</span>';
                    }else {
                        status = '<span class="btn btn-xs btn-danger">Thất bại</span>';
                    }
                    return status;
                },
                className: "text-center"
            }
        ]
    });
}

function loadDataCampaignLog(campaign_id) {
    table_campaign_log.DataTable().destroy();
    showCampaignLog(campaign_id);
}

function loadDataCampaign(campaign_id) {
    $('#readMailModal').modal('show');
    $.ajax({
        type: 'GET',
        url: API_CAMPAIGN_SHOW_BY_ID + campaign_id,
        success: function(data, status, xhr) {
            $('#readTitle').text(data.data.campaign_title);
            $('#readFrom').text(data.data.campaign_email_name);
            $('#readTime').text(data.data.campaign_schedule);
            $('#readContent').html(data.data.campaign_content);
        }
    });
}

function countSend(campaign_id) {
    $.ajax({
        type: 'GET',
        url: API_CAMPAIGN_LOG_COUNT_SEND + campaign_id,
        success: function(data, status, xhr) {
            let count_all = data.data;
            $('.count_total').text(count_all.total);
            // unsent
            $('#count_unsent').text(count_all.unsent.value);
            $('#widthUnsent').css('width', count_all.unsent.percent + '%');
            // sent
            $('#count_sent').text(count_all.sent.value);
            $('#widthSent').css('width', count_all.sent.percent + '%');
            // sent
            $('#count_failure').text(count_all.failure.value);
            $('#widthFailure').css('width', count_all.failure.percent + '%');
        }
    });
}

function showListTemplateAll() {
    $.ajax({
        type: 'GET',
        url: API_TEMPLATE_SHOW_ALL,
        success: function(data, status, xhr) {
            if(data.data.length > 0) {
                $('.selectListTemplate').find('option').remove().end().append('<option value="" selected="selected">Chưa chọn email mẫu</option>').val('whatever');
                for (const template of data.data) {
                    $('.selectListTemplate').append($("<option></option>").attr("value", template.template_id).text(template.template_name));
                }
            }
        }
    });
}

function insertTemplateToContent() {
    $('#selectTemplate').change( () => {
        $('#txtAddCampaignContent').summernote('reset');
        if($('#selectTemplate').val()) {
            $.ajax({
                type: 'GET',
                url: API_TEMPLATE_SHOW_BY_ID + $('#selectTemplate').val(),
                success: function (data, status, xhr) {
                    $('#txtAddCampaignContent').summernote('pasteHTML', data.data.template_content);
                }
            });
        }
    });
}
