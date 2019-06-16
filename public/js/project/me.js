$(document).ready(function() {
    showProject();
});

// Project
let table_project = $('#tableProject');
function showProject() {
    table_project.DataTable({
        ajax: {
            method: "GET",
            url: API_PROJECT_SHOW_BY_CUSTOMER_CURRENT
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
            }
        ]
    });
}
